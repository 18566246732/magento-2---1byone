# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:conversion.py
Author:jing
Copyright:yiguotech.com
date:2017/11/02
--------------------------------------------
"""

__author__ = 'jing'


def convert_method_to_static(cls, obj):
    for attr in dir(obj):
        if attr.startswith('_'):
            continue

        setattr(cls, attr, getattr(obj, attr))
