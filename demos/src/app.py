# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:app.py
Author:jing
Copyright:yiguotech.com
date:2017/11/02
--------------------------------------------
"""
from common.common_managers.background_task_manager import BackgroundTaskManager
from initializer.initializer import init

__author__ = 'jing'


def start():
    BackgroundTaskManager.start_all()


def stop():
    BackgroundTaskManager.stop_all()


if __name__ == '__main__':
    init()
    start()
