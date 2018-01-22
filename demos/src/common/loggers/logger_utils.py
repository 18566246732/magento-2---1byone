# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:logger_utils.py
Author:jing
Copyright:yiguotech.com
date:2017/11/01
--------------------------------------------
"""
import logging

from common.common_utils.conversion import convert_method_to_static

__author__ = 'jing'


class Log(logging.Logger):
    @classmethod
    def initialize(cls, obj):
        convert_method_to_static(cls, obj)

    @staticmethod
    def debug(msg, *args, **kwargs):
        pass

    @staticmethod
    def warning(msg, *args, **kwargs):
        pass

    @staticmethod
    def info(msg, *args, **kwargs):
        pass

    @staticmethod
    def error(msg, *args, **kwargs):
        pass

    @staticmethod
    def exception(msg, *args, exc_info=True, **kwargs):
        pass

    @staticmethod
    def critical(msg, *args, **kwargs):
        pass


log = Log
