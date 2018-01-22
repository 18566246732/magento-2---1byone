# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:hello_apis.py
Author:jing
Copyright:yiguotech.com
date:2018/01/17
--------------------------------------------
"""
import traceback

from flask import request
from jsonschema import validate

from common.api_utils.abstract_api import AbstractApi
from common.api_utils.schema import schema

__author__ = 'jing'


class HelloGetApi(AbstractApi):
    URL = '/ygframe/demo/api/v1/hello'

    NAME = 'name'

    sample_urls = [
        '/ygframe/demo/api/v1/hello?name=jing'
    ]

    args_schema = {
        schema.TYPE: schema.Types.OBJECT,
        schema.PROPERTIES: {
            NAME: {
                schema.TYPE: schema.Types.STRING,
                schema.MIN_LEN: 1
            }
        },
        schema.REQUIRED: [NAME]
    }

    @classmethod
    def validate(cls):
        try:
            validate(request.args, cls.args_schema)
        except Exception as e:
            return cls._failure(40000, traceback.format_exc())
        return None

    @classmethod
    def success(cls, name):
        return cls._success(greeting='Hello {}!'.format(name))
