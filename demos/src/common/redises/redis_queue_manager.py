# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:redis_queue_manager.py
Author:jing
Copyright:yiguotech.com
date:2017/11/06
--------------------------------------------
"""
from common.loggers.logger_utils import log
from common.redises.redis_queue import RedisQueue

__author__ = 'jing'


class RedisQueueManager(object):
    registered = {}
    queues = {}

    @classmethod
    def register(cls, name, share=False):
        if (name, share) in cls.registered:
            log.warning('queue of name:{},share:{}, already registered'.format(name, share))
        redis_queue = RedisQueue()
        cls.registered[(name, share)] = redis_queue
        return redis_queue

    @classmethod
    def bind_all(cls, redis_wrapper):
        for (name, share), queue in cls.registered.items():
            key = redis_wrapper.generate_key(name, share)
            queue.bind(redis_wrapper, key)
            cls.queues[key] = queue

    @classmethod
    def get_sizes(cls):
        return '\n'.join(['{}:{}'.format(key, queue.qsize()) for key, queue in cls.queues.items()])
