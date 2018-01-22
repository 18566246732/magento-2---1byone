# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:query.py
Author:jing
Copyright:yiguotech.com
date:2018/01/16
--------------------------------------------
"""
import click
import sys

__author__ = 'jing'

sys.path.append('../src')
from initializer.globals import FULL_NAME, VERSION, AUTHOR, COPY_RIGHT


@click.group()
def query_group():
    pass


@query_group.command()
def info():
    info_list = [
        'full_name: {}'.format(FULL_NAME),
        'version: {}'.format(VERSION),
        'author: {}'.format(AUTHOR),
        'copyright: {}'.format(COPY_RIGHT),
    ]
    print('\n'.join(info_list))

