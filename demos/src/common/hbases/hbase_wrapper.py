# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:hbase_wrapper.py
Author:jing
Copyright:yiguotech.com
date:2017/11/23
--------------------------------------------
"""
import happybase

from common.common_utils.singleton import Singleton

__author__ = 'jing'


class HbaseWrapper(object, metaclass=Singleton):
    pool = None

    @classmethod
    def __init__(cls, hbase_param: dict) -> None:
        cls.pool = happybase.ConnectionPool(**hbase_param)

    @classmethod
    def connection(cls):
        return cls.pool.connection()
