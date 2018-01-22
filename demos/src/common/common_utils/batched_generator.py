# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:batched_generator.py
Author:jing
Copyright:yiguotech.com
date:2017/12/11
--------------------------------------------
"""
__author__ = 'jing'


def batched_generator(generator, batch_size=1000, item_filter=None):
    batch = []
    i = 0
    for item in generator:
        if item_filter and not item_filter(item):
            continue
        i += 1
        batch.append(item)
        if i < batch_size:
            continue
        else:
            yield batch
            batch.clear()
            i = 0
    else:
        yield batch


if __name__ == '__main__':
    for b in batched_generator(range(0, 126), 10):
        print(b)
