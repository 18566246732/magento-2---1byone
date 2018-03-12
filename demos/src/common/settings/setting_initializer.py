# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:setting_initializer.py
Author:jing
Copyright:yiguotech.com
date:2017/11/03
--------------------------------------------
"""
import yaml

from common.common_managers.background_task_manager import BackgroundTaskManager
from common.settings.setting_converter import SettingConverter

__author__ = 'jing'


class SettingInitializer(object):
    def __init__(
            self,
            config_file='config.yaml',
            config_metadata_file='config.metadata.yaml',
            setting_resolve=None
    ) -> None:
        self.config_file = config_file
        self.config_metadata_file = config_metadata_file
        self.setting_resolver = setting_resolve

    def initialize(self, load_from_local=False, etcd_params=None, etcd_heart_beat=180):
        sc = SettingConverter(self.config_metadata_file, self.setting_resolver)
        if load_from_local:
            with open(self.config_file) as file:
                setting_dict = yaml.safe_load(file.read())
            return sc.dict_to_setting(setting_dict)
        else:  # import etcd locally so you can remove etcd from requirements file if load_from_local is True
            from common.settings.etcd_wrapper import EtcdWrapper
            from common.settings.etcd_converter import EtcdConverter
            wrapper = EtcdWrapper(etcd_params)
            converter = EtcdConverter(self.config_file, wrapper, sc)
            setting = converter.local_to_remote()
            BackgroundTaskManager.register_function_as_task(
                converter.remote_to_local,
                name='etcd_heartbeat',
                wait_time=etcd_heart_beat,
                start_priority=BackgroundTaskManager.Priority.HIGH
            )
            return setting
