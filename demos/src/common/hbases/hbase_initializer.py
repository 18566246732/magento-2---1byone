# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:hbase_initializer.py
Author:jing
Copyright:yiguotech.com
date:2017/11/23
--------------------------------------------
"""
from common.hbases.hbase_wrapper import HbaseWrapper

__author__ = 'jing'


class HbaseInitializer(object):
    def __init__(self, size: int = 5) -> None:
        self.size = size

    def initialize(self, host: str, ):
        hbase_op = HbaseWrapper(
            hbase_param={
                'host': host,
                'size': self.size
            }
        )
        # todo create tables
        return hbase_op
