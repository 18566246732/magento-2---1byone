# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:common_const.py
Author:jing
Copyright:yiguotech.com
date:2017/10/17
--------------------------------------------
"""

__author__ = 'jing'


class CommonConst(object):
    class ConstError(Exception):
        pass

    def __setattr__(self, *_):
        raise self.ConstError('Trying to change a constant value')

    # yiguo standard http response
    RESULT = 'result'
    SUCCESS = 'success'
    FAILURE = 'failure'
    ERROR_CODE = 'error_code'
    REASON = 'reason'
