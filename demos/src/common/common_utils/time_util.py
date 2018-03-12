# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:time_util.py
Author:jing
Copyright:yiguotech.com
date:2017/11/13
--------------------------------------------
"""
import datetime
import time

__author__ = 'jing'


def timestamp():
    return int(time.time())


def date_now():
    return datetime.datetime.now()
