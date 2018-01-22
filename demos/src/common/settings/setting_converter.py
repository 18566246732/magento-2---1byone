# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:setting_converter.py
Author:jing
Copyright:yiguotech.com
date:2017/11/03
--------------------------------------------
"""
import yaml

from common.common_utils.singleton import Singleton

__author__ = 'jing'


class SettingConverter(object, metaclass=Singleton):
    class __Setting(object):
        pass

    setting = __Setting
    type_resolve_map = {
        'int': lambda x: int(x),
        'float': lambda x: float(x),
        'bool': lambda x: x if isinstance(x, bool) else x.upper() == 'TRUE',
        'str': lambda x: x,
        'eval': lambda x: eval(x),
        None: lambda x: x,
    }

    @classmethod
    def __init__(cls, metadata_file='config.metadata.yaml', resolve=None) -> None:
        cls.converter = None
        with open(metadata_file, 'r') as file:
            cls.converter = yaml.safe_load(file.read())
        cls.resolve = resolve

    @classmethod
    def dict_to_setting(cls, ectd_dict):
        cls._convert_dict_setting('root', cls.converter, ectd_dict)
        if cls.resolve:
            cls.resolve(cls.setting)
        return cls.setting

    @classmethod
    def _convert_dict_setting(cls, key: str, convert_data, etcd_data):
        if convert_data is None or isinstance(convert_data, str):
            setattr(cls.setting, key.upper(), cls.type_resolve_map[convert_data](etcd_data))
        if isinstance(convert_data, dict):
            for k, v in convert_data.items():
                cls._convert_dict_setting(k, convert_data[k], etcd_data[k])
