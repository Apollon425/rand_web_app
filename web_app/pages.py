from flask import Blueprint, render_template

pages = Blueprint('pages', __name__)

@pages.route('/produktion/projects2.html')
def home():
    return render_template('projects2.html')

@pages.route('/produktion/production_overview.php')
def produkutionsueberischt():
    return render_template('production_overview.php')


