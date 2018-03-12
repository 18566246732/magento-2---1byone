# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:hdfs_wrapper.py
Author:jing
Copyright:yiguotech.com
date:2017/11/05
--------------------------------------------
"""
from hdfs import InsecureClient

from common.common_utils.singleton import Singleton

__author__ = 'jing'


class HdfsWrapper(object, metaclass=Singleton):
    client = None

    @classmethod
    def __init__(cls, hdfs_params: dict) -> None:
        cls.hdfs_params = hdfs_params
        cls.client = InsecureClient(**hdfs_params)

    @classmethod
    def make_dirs(cls, path):
        if not cls.exists(path):
            cls.client.makedirs(path)

    @classmethod
    def exists(cls, path):
        return cls.client.status(path, strict=False) is not None

    @classmethod
    def list(cls, path):
        return cls.client.list(path)

    @classmethod
    def read_hdfs(cls, path):
        with cls.client.read(path) as reader:
            return reader.read()

    @classmethod
    def write_hdfs(cls, path, data, overwrite=False):
        with cls.client.write(path, overwrite=overwrite) as writer:
            writer.write(data.data)
        return path

    @classmethod
    def delete_hdfs(cls, hdfs_path, recursive=False):
        return cls.client.delete(hdfs_path, recursive)
