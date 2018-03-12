# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:setup.py
Author:jing
Copyright:yiguotech.com
date:2018/01/16
--------------------------------------------
"""
__author__ = 'jing'

from setuptools import setup
import sys

sys.path.append('../src')
print(sys.path)
setup(
    name="query",
    version='0.1',
    py_modules=['query'],
    install_requires=[
        'Click', 'happybase', 'redis', 'PyYAML==3.12', 'elasticsearch5', 'requests', 'tornado', 'python-etcd'
    ],
    entry_points='''
        [console_scripts]
        query=query:query_group

    ''',
)
