# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:schema.py
Author:jing
Copyright:yiguotech.com
date:2018/01/16
--------------------------------------------
"""
__author__ = 'jing'


class _Schema(object):
    DESCRIPTION = 'description'
    TYPE = 'type'
    PROPERTIES = 'properties'
    REQUIRED = 'required'
    ITEMS = 'items'
    MIN_LEN = 'minLength'
    MAX_LEN = 'maxLength'

    class Types:
        NULL = 'null'
        BOOLEAN = 'boolean'
        OBJECT = 'object'
        ARRAY = 'array'
        NUMBER = 'number'
        STRING = 'string'
        INTEGER = 'integer'


schema = _Schema()
