from flask import Flask, render_template, request, flash




def create_app():
    app = Flask(__name__)
    app.config['SECRET_KEY'] = 'hadfdaflh kjlfaL'

    from .pages import pages

    app.register_blueprint(pages, url_prefix="/")

    return app


