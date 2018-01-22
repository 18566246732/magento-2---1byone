# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:mysql_initiliazer.py
Author:jing
Copyright:yiguotech.com
date:2017/11/05
--------------------------------------------
"""
from common.common_utils.singleton import Singleton
from common.mysqls.mysql_wrapper import MysqlWrapper

__author__ = 'jing'


class MysqlInitializer(object, metaclass=Singleton):
    def __init__(self, name_or_url, max_overflow: int = 5, encoding: str = 'utf-8') -> None:
        self.name_or_url = name_or_url
        self.max_overflow = max_overflow
        self.encoding = encoding

    def initialize(self, base):
        mysql_wrapper = MysqlWrapper(engine_params={
            'name_or_url': self.name_or_url,
            'max_overflow': self.max_overflow,
            'encoding': self.encoding
        })
        mysql_wrapper.create_tables(base)
        return mysql_wrapper
