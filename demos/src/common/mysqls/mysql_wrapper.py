# -*- coding:utf-8 -*-
"""
--------------------------------------------
File Name:mysql_wrapper.py
Author:jing
Copyright:yiguotech.com
date:2017/11/05
--------------------------------------------
"""
import contextlib

from sqlalchemy import create_engine
from sqlalchemy.orm import sessionmaker

from common.common_decorators.retry import retry_5
from common.common_utils.singleton import Singleton
from common.loggers.logger_utils import log

__author__ = 'jing'


class MysqlWrapper(object, metaclass=Singleton):
    engine = None
    DB_session = None

    @classmethod
    def __init__(cls, engine_params: dict) -> None:
        cls.engine = create_engine(**engine_params)
        cls.DB_session = sessionmaker(bind=cls.engine)

    @classmethod
    @retry_5
    def _sage_get_session(cls):
        session = cls.DB_session()
        session.connection()
        return session

    @classmethod
    @contextlib.contextmanager
    def get_session(cls, after_commit=None):
        session = cls._sage_get_session()
        try:
            yield session
            session.commit()
            if after_commit:
                after_commit()
        except Exception as e:
            session.rollback()
            raise e
        finally:
            session.close()

    @classmethod
    def create_tables(cls, base):
        try:
            log.info('creating sql tables.')
            base.metadata.create_all(cls.engine)
        except Exception as e:
            log.error('create tables failed {}'.format(str(e)))
