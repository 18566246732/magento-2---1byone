# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:etcd_converter.py
Author:jing
Copyright:yiguotech.com
date:2017/11/04
--------------------------------------------
"""
import yaml

from common.settings.etcd_wrapper import EtcdWrapper
from common.settings.setting_converter import SettingConverter

__author__ = 'jing'


class EtcdConverter(object):
    def __init__(self, config_file: str, etcd_wrapper: EtcdWrapper, setting_converter: SettingConverter) -> None:
        self.config_file = config_file
        self.etcd_wrapper = etcd_wrapper
        self.setting_converter = setting_converter
        with open(self.config_file) as file:
            self.data = yaml.safe_load(file)

    def local_to_remote(self):
        self._put_to_etcd('', self.data)
        return self.setting_converter.dict_to_setting(self.data)

    def remote_to_local(self):
        data = self._get_from_etcd('', self.setting_converter.converter)
        with open(self.config_file, 'w') as file:
            yaml.safe_dump(data, file, default_flow_style=False)
        return True  # for task manager

    def _get_from_etcd(self, key, value):
        if isinstance(value, dict):
            return {
                k: self._get_from_etcd('{}/{}'.format(key, k), v)
                for k, v in value.items()
            }
        else:
            return self.etcd_wrapper.get(key)

    def _put_to_etcd(self, key, value):
        if isinstance(value, dict):
            for k, v in value.items():
                self._put_to_etcd('{}/{}'.format(key, k), v)
        else:
            self.etcd_wrapper.safe_create(key, value)
