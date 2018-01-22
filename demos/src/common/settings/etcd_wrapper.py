# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:etcd_wrapper.py
Author:jing
Copyright:yiguotech.com
date:2017/11/03
--------------------------------------------
"""
import etcd

from common.common_decorators.retry import retry_exception
from common.common_utils.preconditions import assert_not_none
from common.loggers.logger_utils import log

__author__ = 'jing'


class EtcdWrapper(object):
    def __init__(self, etcd_params: dict) -> None:
        self.etcd_params = etcd_params
        self.client = None
        self.client = etcd.Client(**self.etcd_params)

    @retry_exception
    def connect(self):
        assert_not_none(self.etcd_params, 'no params for etcd connection')
        log.info('trying to connect etcd by etcd_params: {}'.format(self.etcd_params))
        version = self.client.version
        log.info('etcd-{} connect successfully'.format(version))
        return version

    def exists(self, key: str) -> bool:
        try:
            self.client.get(key)
            return True
        except etcd.EtcdKeyNotFound:
            return False

    def safe_create(self, key: str, value):
        if self.exists(key):
            return True
        self.client.write(key, value)

    def get(self, key: object, default: object = None) -> object:
        try:
            return self.client.get(key).value
        except:
            return default
