# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:flask_app_initializer.py
Author:jing
Copyright:yiguotech.com
date:2017/11/05
--------------------------------------------
"""
import requests
from flask import request, Flask
from flask_restful import Api
from tornado.httpserver import HTTPServer
from tornado.ioloop import IOLoop
from tornado.wsgi import WSGIContainer

from common.common_managers.background_task_manager import BackgroundTaskManager
from common.common_utils.singleton import Singleton
from common.loggers.logger_utils import log

__author__ = 'jing'


def default_is_alive():
    return 'yes'


def default_after_request(response):
    log.info('{} {} {}'.format(request.method, request.full_path, response.status))
    return response


def init_permission(permission_url, registers):
    return requests.post(
        permission_url,
        json=registers
    )


class FlaskAppInitializer(object, metaclass=Singleton):
    def __init__(self, is_alive=default_is_alive, after_request=default_after_request) -> None:
        self.is_alive = is_alive
        self.after_request = after_request

    @staticmethod
    def _check_prefix(route, prefix):
        for url in route[1:]:
            if not url.startswith(prefix):
                log.warning('{} is not startswith {}.'.format(url, prefix))

    def initialize(
            self,
            system_name: str,
            subsystem_name: str,
            route_list: list,
            listen_port: int,
            permission_url: str = None,
            register_list: list = None,
            tornado_proc_num: int = 1
    ):
        """
        :param system_name:
        :param subsystem_name:
        :param route_list:
            列表的元素是tuple, 每个元素的第一个元素是对应的Resource， 后面的元素是其绑定的一个或多个url
            [
                (ResourceClass_1, url_1),
                (ResourceClass_2, url_2_1, url_2_2),
            ]
        :param listen_port:
        :param permission_url: 详见register_list
        :param register_list: 这个参数与permission_url一起用于权限控制，具体参数形式依赖于yiguo的权限控制模块。
        :param tornado_proc_num:
        :return:
        """
        app = Flask('{}_{}'.format(system_name, subsystem_name))
        prefix = '/{}/{}/api/v'.format(system_name, subsystem_name)

        app.route(prefix + '1/alive')(self.is_alive)
        app.after_request(self.after_request)

        api = Api(app)
        for route in route_list:
            self._check_prefix(route, prefix)
            api.add_resource(*route)

        if register_list:
            registers = {}
            for register in register_list:
                registers.update(register)
            init_permission(permission_url, registers)
        # todo result check 对于注册成功与否进行判定以及相应处理

        http_server = HTTPServer(WSGIContainer(app))
        http_server.bind(listen_port)
        http_server.start(tornado_proc_num)
        instance = IOLoop.instance()
        BackgroundTaskManager.register_function_as_task(
            target=instance.start,
            name='{}_{}_flask_app'.format(system_name, subsystem_name),
            start_priority=BackgroundTaskManager.Priority.LOW,
            stop=instance.stop
        )
        log.info('app start at port:{}'.format(listen_port))
