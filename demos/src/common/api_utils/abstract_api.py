# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:abstract_api.py
Author:jing
Copyright:yiguotech.com
date:2018/01/16
--------------------------------------------
"""
from common.common_utils.common_const import CommonConst
from common.loggers.logger_utils import log

__author__ = 'jing'


class AbstractApi(object):
    @classmethod
    def _success(cls, data: dict = None, **kwargs):
        data = data or {}
        result = {
            CommonConst.RESULT: CommonConst.SUCCESS
        }
        result.update(data)
        result.update(kwargs)
        return result

    @classmethod
    def _failure(cls, error_code=-1, reason=None, data: dict = None, **kwargs):
        data = data or {}
        result = {
            CommonConst.RESULT: CommonConst.FAILURE,
            CommonConst.ERROR_CODE: error_code,
            CommonConst.REASON: reason
        }
        result.update(data)
        result.update(kwargs)
        log.error(result)
        return result
