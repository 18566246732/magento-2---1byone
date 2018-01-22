# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:shell.py
Author:jing
Copyright:yiguotech.com
date:2017/12/09
--------------------------------------------
"""
import types

from common.common_utils.singleton import Singleton

__author__ = 'jing'


class Shell(object, metaclass=Singleton):
    def help(self, operation=None):
        """
        help: get all operations and their arguments
        help <operation>: get specification of the operation
        """

        ops = {}
        for attr in dir(self):
            attr_value = self.__getattribute__(attr)
            if isinstance(attr_value, (types.MethodType, types.FunctionType)):
                name = attr_value.__name__
                doc = attr_value.__doc__
                specification = '{}:{}'.format(name, doc)
                ops.update({name: specification})
        if operation:
            return ops.get(operation)
        return '\n'.join(ops.values())


SHELL = Shell()
