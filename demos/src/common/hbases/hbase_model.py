# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:hbase_model.py
Author:jing
Copyright:yiguotech.com
date:2017/12/09
--------------------------------------------
"""
from abc import abstractmethod

__author__ = 'jing'


class HbaseModel(object):
    @classmethod
    @abstractmethod
    def get_table_name(cls) -> str:
        pass

    @abstractmethod
    def check_valid(self) -> bool:
        pass

    @classmethod
    @abstractmethod
    def get_key_attributes(cls) -> list:
        pass

    @classmethod
    def get_separator(cls) -> str:
        return '_'

    @staticmethod
    def get_main_column_family() -> str:
        return 'attribute:'

    def get_key(self) -> str:
        row_keys = [self.__getattribute__(row_key) for row_key in self.get_key_attributes()]
        return self.get_separator().join(row_keys)

    def generate_column_dict(self, columns: list = None, exclude_columns: list = None) -> dict:
        values = {}
        for k, v in self.__dict__.items():
            if k not in self.get_key_attributes() and v is not None:
                if columns is not None and k not in columns:
                    continue
                if exclude_columns is not None and k in exclude_columns:
                    continue
                values[(self.get_main_column_family() + k).encode()] = str(v).encode()
        return values

    @classmethod
    def create_from_scan(cls, scan_row, columns=None):
        new = cls()
        new.init_from_scan(scan_row, columns)
        return new

    @classmethod
    def create_from_row(cls, key, row_cols, columns=None):
        if not isinstance(key, bytes):
            key = str(key).encode()
        return cls.create_from_scan((key, row_cols), columns)

    def init_from_scan(self, scan_row, columns=None):
        if not isinstance(scan_row, tuple):
            return None
        if len(scan_row) < 2:
            raise ValueError('invalid rows')
        row_key = scan_row[0]
        row_value = scan_row[1]
        keys = row_key.decode().split('-')
        for index, key_attribute in enumerate(self.get_key_attributes()):
            self.__setattr__(key_attribute, keys[index])
        for key, value in row_value.items():
            if columns is not None and key in columns:
                continue
            self.__setattr__(key.decode().split(':')[-1], value.decode())
        return self

    def init_from_key(self, key: str):
        ks = key.split(self.get_separator())
        if len(ks) != len(self.get_key_attributes()):
            raise ValueError('invalid key')
        for index, attr in enumerate(self.get_key_attributes()):
            self.__setattr__(attr, ks[index])

    def __repr__(self) -> str:
        return str(self.__dict__)
