# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:globals.py
Author:jing
Copyright:yiguotech.com
date:2017/11/06
--------------------------------------------
"""
from common.hbases.hbase_wrapper import HbaseWrapper
from common.redises.redis_wrapper import RedisWrapper
from common.settings.setting_converter import SettingConverter

__author__ = 'jing'

SYSTEM_NAME = 'ygframe'
SUBSYSTEM_NAME = 'demo'
FULL_NAME = '{}_{}'.format(SYSTEM_NAME, SUBSYSTEM_NAME)

VERSION = 1.0
AUTHOR = 'jing'
COPY_RIGHT = 'yiguotech.com'

SETTING = SettingConverter.setting()
redis_op = RedisWrapper
hbase_op = HbaseWrapper
# mysql_op = MysqlWrapper

# set background tasks, redis queues, redis tasks, redis statistics
