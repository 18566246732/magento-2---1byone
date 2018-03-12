# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:redis_wrapper.py
Author:jing
Copyright:yiguotech.com
date:2017/11/05
--------------------------------------------
"""
import redis

from common.common_decorators.retry import retry_5
from common.common_utils.singleton import Singleton
from common.redises.redis_queue import RedisQueue

__author__ = 'jing'


class RedisWrapper(object, metaclass=Singleton):
    QUEUE_TYPE = 'q'
    redis_pool_params = None
    default_expire = None
    system_name = None
    subsystem_name = None
    conn = None

    @classmethod
    def __init__(cls, redis_pool_params, default_expire: int = 7776000, system_name='yg',
                 subsystem_name='common', ) -> None:
        cls.redis_pool_params = redis_pool_params
        cls.default_expire = default_expire
        cls.system_name = system_name
        cls.subsystem_name = subsystem_name
        cls.pool = redis.ConnectionPool(**redis_pool_params)
        cls.conn = redis.Redis(connection_pool=cls.pool)
        cls.test_ping()

    @classmethod
    @retry_5
    def test_ping(cls):
        if not cls.conn.ping():
            raise Exception('cannot connect to redis: {}'.format(cls.redis_pool_params))
        return True

    @classmethod
    def generate_key(cls, key, type_name=None, share=False):
        prefix = cls.system_name if share else '{}_{}'.format(cls.system_name, cls.subsystem_name)
        mid = '{}:'.format(type_name) if type_name else ''
        return '{}:{}{}'.format(prefix, mid, key)

    @classmethod
    def expire(cls, name, type_name=None, share=False, time=86400):
        cls.test_ping()
        cls.conn.expire(cls.generate_key(name, type_name, share), time)

    @classmethod
    def get(cls, name: object, type_name: object = None, share=False) -> bytes:
        cls.test_ping()
        return cls.conn.get(cls.generate_key(name, type_name, share))

    @classmethod
    def hset(cls, name, key, value, type_name=None, share=False, **kwargs):
        cls.test_ping()
        cls.conn.hset(cls.generate_key(name, type_name, share), key, value, **kwargs)

    @classmethod
    def hget(cls, name, key, type_name=None, share=False):
        cls.test_ping()
        return cls.conn.hget(cls.generate_key(name, type_name, share), key)

    @classmethod
    def set(cls, name, value, type_name=None, share=False, **kwargs):
        cls.test_ping()
        if 'ex' not in kwargs:
            kwargs['ex'] = cls.default_expire
        cls.conn.set(cls.generate_key(name, type_name, share), value, **kwargs)

    @classmethod
    def get_queue(cls, name, share=False):
        cls.test_ping()
        return RedisQueue(cls.conn, cls.generate_key(name, cls.QUEUE_TYPE, share))
