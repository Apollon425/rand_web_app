from web_app import create_app
import os

app = create_app()


if __name__=='__main__':
    app.run(debug=True, host="192.168.178.37")  #  debug=True: restarts web server every time a change is made to the web server
