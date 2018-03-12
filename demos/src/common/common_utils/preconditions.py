# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:preconditions.py
Author:jing
Copyright:yiguotech.com
date:2017/11/02
--------------------------------------------
"""
import numbers

from common.loggers.logger_utils import log

__author__ = 'jing'


def is_positive_integer(num):
    return isinstance(num, int) and num > 0


def check_positive_integer(num, **default):
    """
    :param num: the param to be check
    :param default: param_name=default_value
    :return:num if is a positive integer, else return a default value

    example:
        def fuc(x:int):
            x = check_positive_integer(x, x=1)
            ...
    """
    if is_positive_integer(num):
        return num
    key, value = 'param', 1
    if len(default) >= 1:
        key, value = [(k, v) for k, v in default.items()][0]
        log.error('ValueError, {} must be a positive integer'.format(key))

    return value


def is_positive_number(num):
    return isinstance(num, numbers.Number) and num > 0


def check_positive_number(num, **default):
    """
    :param num: the param to be check
    :param default: param_name=default_value
    :return:num if is a positive number, else return a default value

    example:
        def fuc(x):
            x = check_positive_number(x, x=1)
            ...
    """
    if is_positive_number(num):
        return num
    key, value = 'param', 1
    if len(default) >= 1:
        key, value = [(k, v) for k, v in default.items()][0]
        log.error('ValueError, {} must be a positive number'.format(key))

    return value


def is_callable(func):
    return callable(func)


def check_callable(func, **default):
    """
    :param func: the param to be check
    :param default: param_name=default_value
    :return:func if is a callable object, else return the default value

    example:
        def fuc(x):
            x = check_callable(x, x=1)
            ...
    """
    if is_callable(func):
        return func
    key, value = 'param', lambda x: x
    if len(default) >= 1:
        key, value = [(k, v) for k, v in default.items()][0]
        log.error('ValueError, {} must be a callable object'.format(key))

    return value


def assert_not_none(obj, msg='None is not an acceptble param'):
    if obj is None:
        raise ValueError(msg)
    return obj
