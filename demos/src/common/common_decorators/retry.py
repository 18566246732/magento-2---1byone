# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:retry.py
Author:jing
Copyright:yiguotech.com
date:2017/11/02
--------------------------------------------
"""
import numbers
import time
from functools import wraps

from common.common_utils.preconditions import check_positive_integer, check_positive_number, check_callable
from common.loggers.logger_utils import log

__author__ = 'jing'


class Retry:
    FOREVER = None
    DEFAULT_MAX_RETRY = 3
    DEFAULT_SLEEP_TIME = 1


class MaxRetryError(Exception):
    pass


class NoneResultError(Exception):
    pass


def retry(
        max_retry: int = Retry.FOREVER,
        name: str = None,
        sleep: numbers.Number = Retry.DEFAULT_SLEEP_TIME,
        sleep_strategy=None,
        can_be_none=False,
        default_result=None,
):
    """
    :param max_retry: retry times. None means keep retry forever until function call success
    :param name: retry task name. if omit, name will be the function name
    :param sleep: time sleep seconds.
    :param sleep_strategy: a callable takes turn number as param, returns sleep seconds. if not None, param sleep
            will be ignore
    :param can_be_none: True if None is an acceptable result
    :param default_result: 如果不是None，重试失败后返回这个值，如果是None，失败后产生异常
    :return: value of function return or None
    """
    if max_retry != Retry.FOREVER:
        max_retry = check_positive_integer(max_retry, limit=None)
    if sleep_strategy is None:
        sleep = check_positive_number(sleep, sleep=1)
    else:
        sleep_strategy = check_callable(sleep_strategy, sleep_strategy=lambda x: x)

    def decorate(func):
        @wraps(func)
        def wrapper(*args, **kwargs):
            nonlocal name
            if not name:
                name = func.__name__
            retry_turn = 0
            while True:
                try:
                    return_value = func(*args, **kwargs)
                    if not can_be_none and return_value is None:
                        raise NoneResultError('{} returns None'.format(name))
                    return return_value
                except:
                    retry_turn += 1
                    msg = '{} failed, args:{}, kwargs:{}, retry turn:{}.'.format(name, args, kwargs, retry_turn)
                    log.warning(msg, exc_info=True)

                    if max_retry and retry_turn > max_retry:
                        break

                    sleep_seconds = sleep_strategy(retry_turn) if sleep_strategy else sleep
                    log.warning('next turn retry {} will start after {} seconds'.format(name, sleep_seconds))
                    time.sleep(sleep_seconds)
            if default_result:
                return default_result
            raise MaxRetryError('{} failed, retry times:{}'.format(name, retry_turn))

        return wrapper

    return decorate


def annealing(turn):
    turn = min(turn, 15)
    return 2 ** turn


retry_exception = retry(max_retry=Retry.FOREVER, sleep_strategy=annealing)
retry_none = retry(max_retry=Retry.FOREVER, sleep_strategy=annealing, can_be_none=False)
retry_5 = retry(max_retry=6, sleep_strategy=annealing, can_be_none=False)
