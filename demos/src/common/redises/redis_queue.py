# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:redis_queue.py
Author:jing
Copyright:yiguotech.com
date:2017/11/06
--------------------------------------------
"""
from common.common_utils.singleton import Singleton
from common.loggers.logger_utils import log

__author__ = 'jing'


class RedisQueue(object, metaclass=Singleton):
    def __init__(self, redis_conn=None, key=None):
        self.redis_conn = redis_conn
        self.key = key

    def bind(self, redis_conn, key):
        self.redis_conn = redis_conn
        self.key = key

    def qsize(self):
        return self.redis_conn.llen(self.key)

    def clear(self):
        return self.redis_conn.delete(self.key)

    def empty(self):
        return self.qsize() == 0

    def put(self, item):
        self.redis_conn.rpush(self.key, item)

    def get(self, block: object = False, timeout: object = None) -> object:
        try:
            item_result = None
            if block:
                item = self.redis_conn.blpop(self.key, timeout=timeout)
                if item:
                    item_result = item[1].decode('utf-8')
            else:
                item = self.redis_conn.lpop(self.key)
                if item:
                    item_result = item.decode('utf-8')
        except Exception as error:
            log.error(str(error))
            item_result = None

        return item_result
