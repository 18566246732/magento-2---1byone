# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:logger_initializer.py
Author:jing
Copyright:yiguotech.com
date:2017/11/01
--------------------------------------------
"""
import logging
import os
from distutils.dir_util import mkpath
from logging import config

import yaml

from common.common_utils.singleton import Singleton
from common.loggers.logger_utils import log

__author__ = 'jing'


class LoggerInitializer(object, metaclass=Singleton):
    def __init__(
            self,
            log_config_file='logging.yaml',
            env_key='LOG_CFG',
            logger_path: str = '../../data/logs',
    ) -> None:
        """
        :param log_config_file: file path of logger config
        :param env_key: by setting environment variable, you can set a file path
        params above provide a logger config file path.
        :param logger_path:
        this four provide a rotating file config, use to build a system logger,and other added loggers
        """
        self.log_config_file = log_config_file
        self.env_key = env_key
        self.logger_path = logger_path

    def initialize(self):
        if not os.path.exists(self.logger_path):
            mkpath(self.logger_path)
        value = os.getenv(self.env_key, None)
        path = value or self.log_config_file

        try:
            with open(path, 'r') as f:
                configuration = yaml.load(f.read())
                config.dictConfig(configuration)
        except FileNotFoundError:
            logging.exception('logging config file not found')
        except ValueError:
            logging.exception('logging config file format error or dictionary not found')

        common_logger = logging.getLogger()
        log.initialize(common_logger)
