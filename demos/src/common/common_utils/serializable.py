# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:serializable.py
Author:jing
Copyright:yiguotech.com
date:2017/11/13
--------------------------------------------
"""
import json

__author__ = 'jing'


class Serializable(object):
    def get_serialize_attr_list(self):
        return self.__dict__.keys()

    @classmethod
    def unpack_to_dict(cls, value):
        if isinstance(value, (list, set, tuple)):
            copy = value.copy()
            for i, item in enumerate(value):
                copy[i] = cls.unpack_to_dict(item)
            return copy
        elif isinstance(value, dict):
            copy = value.copy()
            for key, value in copy.items():
                copy[cls.unpack_to_dict(key)] = cls.unpack_to_dict(value)
            return copy
        elif isinstance(value, (int, str, bool)) or value is None:
            return value
        elif isinstance(value, Serializable):
            copy = {
                attr: value.__getattribute__(attr)
                for attr in value.get_serialize_attr_list()
            }
            return cls.unpack_to_dict(copy)
        elif isinstance(value, object):
            copy = {
                attr: value.__getattribute__(attr)
                for attr in value.__dict__
            }
            return cls.unpack_to_dict(copy)
        else:
            raise Exception('unsolved data')

    def dumps(self):
        return json.dumps({
            attr: self.__getattribute__(attr)
            for attr in self.get_serialize_attr_list()
        })

    @classmethod
    def loads(cls, json_str):
        json_dict = json.loads(json_str)
        self = cls()
        for attr, value in json_dict.items():
            self.__setattr__(attr, value)
        return self
