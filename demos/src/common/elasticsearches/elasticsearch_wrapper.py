# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:elasticsearch_wrapper.py
Author:jing
Copyright:yiguotech.com
date:2017/11/27
--------------------------------------------
"""
from elasticsearch5 import Elasticsearch, helpers

from common.common_utils.singleton import Singleton

__author__ = 'jing'


class EsWrapper(object, metaclass=Singleton):
    es = None

    @classmethod
    def __init__(cls, elasticsearch_params) -> None:
        cls.es = Elasticsearch(**elasticsearch_params)

    @classmethod
    def bulk(cls, actions, **kwargs):
        if cls.es is None:
            raise ValueError('not initialized')
        return helpers.bulk(cls.es, actions, **kwargs)

    @classmethod
    def scan(cls, index=None, doc_type=None, query=None, scroll='5m', size=1000, request_timeout=None,
             clear_scroll=True,
             **kwargs):
        return helpers.scan(cls.es, index=index, doc_type=doc_type, query=query, scroll=scroll, size=size,
                            request_timeout=request_timeout,
                            clear_scroll=clear_scroll, **kwargs)

    @classmethod
    def search(cls, index=None, doc_type=None, body=None, from_=0, size=20, **kwargs):
        if cls.es is None:
            raise ValueError('not initialized')
        return cls.es.search(index=index, doc_type=doc_type, body=body, from_=from_,
                             size=size, **kwargs)
