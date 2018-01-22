# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:HelloWorld.py
Author:jing
Copyright:yiguotech.com
date:2018/01/17
--------------------------------------------
"""
from flask import request
from flask_restful import Resource

from api.v1.apis.hello_apis import HelloGetApi

__author__ = 'jing'


class Hello(Resource):
    @classmethod
    def get(cls):
        api = HelloGetApi
        error = api.validate()
        if error:
            return error

        name = request.args.get(api.NAME)
        return api.success(name)
