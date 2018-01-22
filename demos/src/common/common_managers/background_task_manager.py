# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:background_task_manager.py
Author:jing
Copyright:yiguotech.com
date:2017/11/04
--------------------------------------------
"""
from common.backgroud_tasks.background_task import BackgroundTask
from common.common_decorators.logger_decorators import log_exception_decorate
from common.loggers.logger_utils import log

__author__ = 'jing'


class BackgroundTaskManager(object):
    all_background_tasks = {}

    class Priority:
        LOW = 0
        MIDDLE = 50
        HIGH = 100

        @classmethod
        def opposite_to(cls, priority):
            return cls.HIGH - priority

    @classmethod
    @log_exception_decorate()
    def register(cls, task: BackgroundTask, start_priority=Priority.MIDDLE, stop_priority=None):
        if stop_priority is None:
            stop_priority = cls.Priority.opposite_to(start_priority)
        name = task.get_name()
        if name in cls.all_background_tasks:
            log.warning('duplicate tasks named :{}'.format(name))

        cls.all_background_tasks[name] = task, start_priority, stop_priority

    @classmethod
    @log_exception_decorate()
    def start_all(cls):
        task_names = cls.all_background_tasks.keys()
        ordered_task_names = sorted(task_names, key=lambda name: cls.all_background_tasks[name][1], reverse=True)
        for task in ordered_task_names:
            cls.start(task)

    @classmethod
    @log_exception_decorate()
    def start(cls, name):
        if name not in cls.all_background_tasks:
            log.warning('task {} has not registered to manager ')
        else:
            task = cls.all_background_tasks[name][0]
            if not task.is_running():
                task.start()
            else:
                log.warning('task {} is running while you try to start it!'.format(name))

    @classmethod
    @log_exception_decorate()
    def stop_all(cls):
        task_names = cls.all_background_tasks.keys()
        ordered_task_names = sorted(task_names, key=lambda name: cls.all_background_tasks[name][2], reverse=True)
        for task in ordered_task_names:
            cls.stop(task)

    @classmethod
    @log_exception_decorate()
    def stop(cls, name):
        if name not in cls.all_background_tasks:
            log.warning('task {} has not registered to manager ')
        else:
            task = cls.all_background_tasks[name][0]
            if task.get_status() not in [BackgroundTask.Status.STOPPED, BackgroundTask.Status.STOPPING]:
                task.stop()
            else:
                log.warning('task {} is {}'.format(name, task.get_status()))

    @classmethod
    @log_exception_decorate()
    def get_recent_logs(cls, name):
        if name not in cls.all_background_tasks:
            return 'task {} has not registered to manager'.format(name)
        else:
            return cls.all_background_tasks[name][0].recent_logs()

    @classmethod
    @log_exception_decorate()
    def get_status(cls):
        task_status = [
            '{}:{}'.format(name, task[0].get_status())
            for name, task in cls.all_background_tasks.items()
        ]
        return '\n'.join(task_status)

    @classmethod
    @log_exception_decorate()
    def register_function_as_task(
            cls, target, args=(), kwargs=None,
            start_priority=Priority.MIDDLE, stop_priority=None,
            name=None, wait_time=7776000, stop=None
    ):
        kwargs = kwargs or {}

        class _InnerTask(BackgroundTask):
            def get_wait_time(self) -> int:
                return wait_time

            def run(self) -> bool:
                return target(*args, **kwargs)

            def get_name(self) -> str:
                return name or target.__name__

            def stop(self):
                if stop is not None:
                    stop()
                super().stop()

        cls.register(_InnerTask(), start_priority, stop_priority)
