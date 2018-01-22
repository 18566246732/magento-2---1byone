# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:logger_decorators.py
Author:jing
Copyright:yiguotech.com
date:2017/11/02

wraps function with try exception block
--------------------------------------------
"""
import logging
from functools import wraps, partial

from common.loggers.logger_utils import log

__author__ = 'jing'


def get_log_method(level: int, logger=log):
    return {
        logging.DEBUG: logger.debug,
        logging.INFO: logger.info,
        logging.WARN: logger.warn,
        logging.WARNING: logger.warning,
        logging.ERROR: logger.error,
        logging.CRITICAL: logger.critical,
    }[level]


def log_exception_decorate(level: int = logging.INFO, msg=None, default=None, logger=log):
    """
    :param level: logger level
    :param msg: the message to explain, if omitted, the function name will be used
    :param default: the default value to be returned when exception raised.
    :param logger: the logger, if omitted, use system default log of yiguo_frame
    :return: return the wrapped function's return value if no exception raised, otherwise
            return the value of `default`
    """

    def decorate(func):
        @wraps(func)
        def wrapper(*args, **kwargs):
            try:
                result = func(*args, **kwargs)
                return result
            except Exception:
                nonlocal msg
                get_log_method(level, logger)(msg or func.__name__, exc_info=True)
                return default

        return wrapper

    return decorate


debug_exception_decorate = partial(log_exception_decorate, level=logging.DEBUG)
info_exception_decorate = partial(log_exception_decorate, level=logging.INFO)
warning_exception_decorate = partial(log_exception_decorate, level=logging.WARNING)
error_exception_decorate = partial(log_exception_decorate, level=logging.ERROR)
critical_exception_decorate = partial(log_exception_decorate, level=logging.CRITICAL)
