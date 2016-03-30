#!/usr/bin/env python3
# -*- coding:utf-8 -*-
from bottle import route, run, view, static_file, url

@route('/static/<filepath:path>', name='static_file')
def static(filepath):
    return static_file(filepath, root="./static")

@route('/', name="index")
@view("index_template")
def index():
    return dict(url=url)

@route('/<name>/<count:int>', name="hello")
@view("hello_template")
def hello(name, count):
    return dict(name=name, count=count, url=url)

if __name__ == '__main__':
    run(host='0.0.0.0', port=8086, debug=True, reloader=True)
