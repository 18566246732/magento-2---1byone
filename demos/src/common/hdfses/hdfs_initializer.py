# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:hdfs_initializer.py
Author:jing
Copyright:yiguotech.com
date:2017/11/05
--------------------------------------------
"""
from common.hdfses.hdfs_wrapper import HdfsWrapper

__author__ = 'jing'


class HdfsInitializer(object):
    def __init__(self, url, user) -> None:
        self.url = url
        self.user = user

    def initialize(self):
        return HdfsWrapper(hdfs_params={
            'url': self.url,
            'user': self.user
        })
