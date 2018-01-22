# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:elasticsearch_initializer.py
Author:jing
Copyright:yiguotech.com
date:2017/12/11
--------------------------------------------
"""
from common.elasticsearches.elasticsearch_wrapper import EsWrapper

__author__ = 'jing'


class EsInitializer(object):
    def initialize(self, *es_url):
        es_op = EsWrapper(
            elasticsearch_params={
                'hosts': list(es_url)
            }
        )
        return es_op
