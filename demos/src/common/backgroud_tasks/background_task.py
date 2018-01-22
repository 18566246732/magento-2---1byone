# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:background_task.py
Author:jing
Copyright:yiguotech.com
date:2017/11/03
--------------------------------------------
"""
import traceback
from abc import abstractmethod
from datetime import datetime
from threading import Thread, Condition

from common.loggers.logger_utils import Log

__author__ = 'jing'


class BackgroundTask(object):
    class Status:
        RUNNING = 'running'
        STOPPING = 'stopping'
        WAITING = 'waiting'
        STOPPED = 'stopped'

    def __init__(self) -> None:
        # control data
        self.condition = Condition()
        self.waiting = False
        self.running = False
        self.stopping = False
        name = self.get_name()
        self.logger = TaskLog()

        # new target
        def proxy_target():
            turn = 0
            logger = self.logger
            while self.running:
                turn += 1
                logger.info('starting task {}, turn={}'.format(name, turn))
                try:
                    self.run()
                except:
                    logger.error('exception raised at task {}, turn: {}'.format(name, turn), exc_info=True)

                wait_time = self.get_wait_time()
                if isinstance(wait_time, int) and wait_time <= 0:
                    continue

                # waiting for notify
                if self.running:
                    with self.condition:
                        self.waiting = True

                        # log
                        if isinstance(wait_time, int):
                            if wait_time > 0:
                                logger.info(
                                    'task {} waiting for notify, timeout={}, turn={}'.format(name, wait_time, turn)
                                )
                        elif wait_time is None:
                            logger.info('task {} waiting for notify, turn={}'.format(name, turn))

                        # wait
                        notify = self.condition.wait_for(lambda: not self.waiting, timeout=self.get_wait_time())
                        if notify:
                            logger.info('task {} notified by an event'.format(name))
                        self.waiting = False

            # exiting
            self.stopping = False
            self.running = False
            logger.info('task: {} stopped'.format(name))

        self.proxy_target = proxy_target

    def notify(self):
        with self.condition:
            if self.waiting:
                self.waiting = False
                self.condition.notify()

    def is_running(self) -> bool:
        return self.running

    def get_status(self) -> str:
        if self.stopping:
            return self.Status.STOPPING
        if self.waiting:
            return self.Status.WAITING
        if self.running:
            return self.Status.RUNNING
        return self.Status.STOPPED

    def start(self):
        self.running = True
        Thread(target=self.proxy_target, name=self.get_name()).start()

    def stop(self):
        self.notify()
        self.stopping = True
        self.running = False

    def restart(self):
        self.stop()
        self.start()

    @abstractmethod
    def run(self):
        raise Exception('unimplemented method')

    @abstractmethod
    def get_name(self) -> str:
        raise Exception('unimplemented method')

    def get_wait_time(self):
        """
        :return: wait seconds when task finished for one turn.
        the value could be:
            a positive integer for waiting specified seconds
            WaitTime.FOREVER for keeping waiting until notified
            WaitTime.NO_WAIT for no wait
        """
        return None

    def recent_logs(self):
        return self.logger.get_recent_messages()


class WaitTime(object):
    FOREVER = None
    NO_WAIT = 0


class TaskLog(object):
    def __init__(self) -> None:
        self.recent_messages = []
        self.max_count = 30
        self.index = 0

    def resize_max(self, max_count):
        self.max_count = max_count

    def get_recent_messages(self):
        if len(self.recent_messages) <= self.index:
            return '\n'.join(self.recent_messages)
        else:
            return '\n'.join(self.recent_messages[self.index:] + self.recent_messages[0:self.index])

    def add_log(self, msg, **kwargs):
        if 'exc_info' in kwargs and kwargs['exc_info'] is True:
            exc_msg = '\n' + traceback.format_exc()
        else:
            exc_msg = ''
        message = '[{}]:{}{}'.format(datetime.now(), msg, exc_msg)
        if len(self.recent_messages) <= self.index:
            self.recent_messages.append(message)
        else:
            self.recent_messages[self.index] = message
            self.index = (self.index + 1) % self.max_count

    def debug(self, msg, *args, **kwargs):
        Log.debug(msg, *args, **kwargs)
        self.add_log(msg, **kwargs)

    def warning(self, msg, *args, **kwargs):
        Log.warning(msg, *args, **kwargs)
        self.add_log(msg, **kwargs)

    def info(self, msg, *args, **kwargs):
        Log.info(msg, *args, **kwargs)
        self.add_log(msg, **kwargs)

    def error(self, msg, *args, **kwargs):
        Log.error(msg, *args, **kwargs)
        self.add_log(msg, **kwargs)

    def exception(self, msg, *args, exc_info=True, **kwargs):
        Log.exception(msg, *args, exc_info=exc_info, **kwargs)
        self.add_log(msg, **kwargs)

    def critical(self, msg, *args, **kwargs):
        Log.critical(msg, *args, **kwargs)
        self.add_log(msg, **kwargs)
