# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:singleton.py
Author:jing
Copyright:yiguotech.com
date:2017/11/06
--------------------------------------------
"""
__author__ = 'jing'


class Singleton(type):
    _instances = {}

    def __call__(cls, *args, **kwargs):
        if cls not in cls._instances:
            cls._instances[cls] = super(Singleton, cls).__call__(*args, **kwargs)
        return cls._instances[cls]
