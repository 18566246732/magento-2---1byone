# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:elasticsearch_query_util.py
Author:jing
Copyright:yiguotech.com
date:2017/11/27
--------------------------------------------
"""
import requests

from common.elasticsearches.elasticsearch_wrapper import EsWrapper
from initializer.globals import SETTING

__author__ = 'jing'


def term(**kwargs):
    return {
        'term': kwargs
    }


def prefix(**kwargs):
    return {
        'prefix': kwargs
    }


def terms(**kwargs):
    return {
        'terms': kwargs
    }


def range_(key, gt=None, gte=None, lt=None, lte=None):
    range_dict = {
        k: v for k, v in {'gt': gt, 'gte': gte, 'lt': lt, 'lte': lte}.items() if v is not None
    }
    return {
        'range': {
            key: range_dict
        }
    }


def and_(*args):
    return {
        'bool': {
            'must': list(args)
        }
    }


def exists_(field):
    return {
        "exists": {
            "field": field
        }
    }


def not_(q):
    return {
        'not': q
    }


def or_(*args):
    return {
        'bool': {
            'should': list(args)
        }
    }


def multi(*args):
    return list(args)


def desc(key):
    return {
        key: 'desc'
    }


def asc(key):
    return {
        key: 'asc'
    }


class EsUtil(object):
    def __init__(self, _index, _type) -> None:
        self._index = _index
        self._type = _type

    def search(self, flt=None, sort=None, page=0, size=20, **kwargs):
        body = {}
        sort = sort or {}
        if flt:
            body = self.query(flt, sort)
        return EsWrapper.search(index=self._index, doc_type=self._type, body=body, from_=page * size, size=size,
                                **kwargs)

    def query(self, flt, sort=None):
        query_json = {
            'query': {
                'filtered': {
                    'query': {
                        'match_all': {}
                    },
                    'filter': flt
                }
            }
        }
        if sort:
            query_json.update({'sort': sort})
        return query_json

    def bulk(self, generator, **kwargs):
        return EsWrapper.bulk(self._actions(generator), **kwargs)

    def scan(self, query=None, scroll='5m', size=1000, request_timeout=None, clear_scroll=True, **kwargs):
        return EsWrapper.scan(index=self._index, doc_type=self._type, query=query, size=size, scroll=scroll,
                              request_timeout=request_timeout, clear_scroll=clear_scroll,
                              **kwargs)

    def _actions(self, generator):
        for key, dict_item in generator:
            yield {
                '_index': self._index,
                '_type': self._type,
                '_id': key,
                '_op_type': 'update',
                'doc': dict_item,
                'doc_as_upsert': True
            }


if __name__ == '__main__':
    pass
