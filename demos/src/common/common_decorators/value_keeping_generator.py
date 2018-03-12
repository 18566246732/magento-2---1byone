# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:value_keeping_generator.py
Author:jing
Copyright:yiguotech.com
date:2017/12/09
--------------------------------------------
"""
from functools import wraps

__author__ = 'jing'


class ValueKeepingGenerator(object):
    def __init__(self, g):
        self.g = g
        self.value = None

    def __iter__(self):
        self.value = yield from self.g


def keep_value(f):
    @wraps(f)
    def g(*args, **kwargs):
        return ValueKeepingGenerator(f(*args, **kwargs))

    return g
