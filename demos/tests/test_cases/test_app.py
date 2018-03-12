# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:test_app.py.py
Author:jing
Copyright:yiguotech.com
date:2017/12/14
--------------------------------------------
"""

import time
from contextlib import contextmanager

import coverage as coverage
import requests

__author__ = 'jing'


def start():
    import sys
    sys.path.append('../../src')
    sys.path.append('../')
    from initializer.initializer import init
    from common.common_managers.background_task_manager import BackgroundTaskManager

    init(load_from_local=True)
    BackgroundTaskManager.start_all()


def stop():
    from common.common_managers.background_task_manager import BackgroundTaskManager
    BackgroundTaskManager.stop_all()


@contextmanager
def running_app(source, debug=True, wait_running=300):
    cov = coverage.Coverage(source=source)
    if not debug:
        cov.start()
    start()
    yield
    time.sleep(wait_running)
    stop()
    if not debug:
        cov.stop()
        cov.html_report()


def test_main():
    with running_app(['../../src/api'], debug=False, wait_running=6):
        from initializer.globals import SETTING

        local_host = 'http://127.0.0.1:{}'.format(SETTING.LISTEN_PORT)
        from api.v1.apis.hello_apis import HelloGetApi
        resp = requests.get(
            '{}{}?{}=jing'.format(local_host, HelloGetApi.URL, HelloGetApi.NAME)
        )
        print(resp.json())
        resp = requests.get(
            '{}{}?{}='.format(local_host, HelloGetApi.URL, HelloGetApi.NAME)
        )
        print(resp.json())


if __name__ == '__main__':
    test_main()
