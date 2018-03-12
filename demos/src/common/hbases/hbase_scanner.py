# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:hbase_scanner.py
Author:jing
Copyright:yiguotech.com
date:2017/12/09
--------------------------------------------
"""

from common.hbases.hbase_model import HbaseModel
from common.hbases.hbase_wrapper import HbaseWrapper
from common.loggers.logger_utils import log

__author__ = 'jing'


class HbaseScanner(object):
    def __init__(self, hbase_model_class, logger=None, print_interval=5000, batch_size=1000):
        if issubclass(hbase_model_class, HbaseModel):
            self.hbase_model_class = hbase_model_class
            self.logger = logger or log
            self.print_interval = print_interval
            self.batch_size = batch_size
            self.table_name = hbase_model_class.get_table_name()
        else:
            raise ValueError

    def scan(self, *args, **kwargs):
        if 'row_prefix' in kwargs:
            prefix = str(kwargs['row_prefix'])
            last_start_row = prefix.encode()
            kwargs['row_prefix'] = None
            kwargs['row_stop'] = (prefix + '~').encode()
        else:
            last_start_row = b''

        self.logger.info('starting scan product...args :{}, kwargs:{} '.format(args, kwargs))
        index = 0
        while last_start_row is not None:
            with HbaseWrapper.connection() as conn:
                table = conn.table(self.table_name)
                kwargs['row_start'] = last_start_row
                scanner = table.scan(*args, **kwargs)
                for scan in scanner:
                    index += 1
                    if index % self.print_interval == 0:
                        self.logger.info('{} scanner index : {}'.format(self.table_name, index))
                    item = self.hbase_model_class.create_from_scan(scan)
                    if isinstance(item, HbaseModel) and item.check_valid():
                        yield item
                    if index % self.batch_size == 0:
                        try:
                            last_start_row = scanner.__next__()[0]
                        except:
                            last_start_row = None
                        break
                else:
                    break
        self.logger.info('end scanning {} : {}'.format(self.table_name, index))
