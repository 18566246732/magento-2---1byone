# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:test_loggers.py
Author:jing
Copyright:yiguotech.com
date:2018/01/16
--------------------------------------------
"""
import logging
import sys
import warnings
from timeit import timeit

__author__ = 'jing'

if __name__ == '__main__':
    sys.path.append('../../../src')
    from common.loggers.logger_initializer import LoggerInitializer

    LoggerInitializer().initialize()
    from common.loggers.logger_utils import log

    log.debug('debug')
    log.info('info')
    log.warning('warning')
    log.error('error')
    log.critical('critical')
    warnings.warn('warnings warn')

    logger = logging.getLogger('test_logger')
    log = logger

    log.debug('debug')
    log.info('info')
    log.warning('warning')
    log.error('error')
    log.critical('critical')
    print(log.propagate)
