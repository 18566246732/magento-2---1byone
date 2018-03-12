# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:initializer.py
Author:jing
Copyright:yiguotech.com
date:2017/11/06
--------------------------------------------
"""
import os

from api.v1.apis.hello_apis import HelloGetApi
from api.v1.resources.hello import Hello
from common.flask_apps.flask_app_initializer import FlaskAppInitializer
from common.hbases.hbase_initializer import HbaseInitializer
from common.loggers.logger_initializer import LoggerInitializer
from common.redises.redis_initiliazer import RedisInitializer
from common.settings.setting_initializer import SettingInitializer
from initializer.globals import FULL_NAME, SYSTEM_NAME, SUBSYSTEM_NAME, SETTING

__author__ = 'jing'


def init(load_from_local=False):
    LoggerInitializer().initialize()
    SettingInitializer().initialize(etcd_params={
        'host': os.environ.get('ETCD_SERVICE_SERVICE_HOST', '192.168.0.1'),
        'port': int(os.environ.get('ETCD_SERVICE_SERVICE_PORT', '22379')),
    }, load_from_local=load_from_local, etcd_heart_beat=300)
    RedisInitializer().initialize(
        host=SETTING.REDIS_HOST,
        password=SETTING.REDIS_PASSWORD,
        system_name=SYSTEM_NAME,
        subsystem_name=SUBSYSTEM_NAME
    )

    HbaseInitializer().initialize(
        host=SETTING.HBASE_HOST
    )

    FlaskAppInitializer().initialize(
        system_name=SYSTEM_NAME,
        subsystem_name=SUBSYSTEM_NAME,
        route_list=[
            (Hello, HelloGetApi.URL)
        ],
        listen_port=SETTING.LISTEN_PORT
    )
