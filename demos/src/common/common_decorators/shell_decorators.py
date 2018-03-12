# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:shell_decorators.py
Author:jing
Copyright:yiguotech.com
date:2017/12/09
--------------------------------------------
"""
from functools import wraps

from common.admin_shell_util.shell import SHELL

__author__ = 'jing'


def shell_method(func):
    SHELL.__setattr__(func.__name__, func)

    @wraps(func)
    def wrapper(*args, **kwargs):
        return func(*args, **kwargs)

    return wrapper
