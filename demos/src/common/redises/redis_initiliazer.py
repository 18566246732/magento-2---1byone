# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:redis_initiliazer.py
Author:jing
Copyright:yiguotech.com
date:2017/11/06
--------------------------------------------
"""
from common.common_utils.singleton import Singleton
from common.redises.redis_wrapper import RedisWrapper

__author__ = 'jing'


class RedisInitializer(object, metaclass=Singleton):
    def __init__(self, default_expire=7776000, port=6379) -> None:
        self.port = port
        self.default_expire = default_expire

    def initialize(self, host, password, system_name, subsystem_name, ):
        params = {
            'host': host,
            'port': self.port
        } if not password or len(password) < 2 else {
            'host': host,
            'port': self.port,
            'password': password
        }
        return RedisWrapper(
            redis_pool_params=params,
            default_expire=self.default_expire,
            system_name=system_name,
            subsystem_name=subsystem_name
        )
