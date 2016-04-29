__author__ = 'Timbo_KZ'


import praw
import time
import threading

# Configuration start
username = 'TheBassMonster'  # Your reddit username
password = 'doomdoomdoom'  # Your reddit password
subredditName = 'HyperBlocksDev'  # Suberddit name (you must be a moderator)
stylesheetPath = 'D:/Workspaces/Web/Server/home/timbo.kz/www/reddit/HyperBlocks/includes/css/HyperBlocks.css'  # Path to your stylesheetsubredditName = 'Aeolus' # Suberddit name (you must be a moderator)
clientID = 'hHR-wzNO5rvZNg'  # Your app's ID
clientSecret = 'LePJyV2l2rSOi2zMJC-p6uDI3ak'  # You app's secret
clientCallback = 'http://127.0.0.1:65010/authorize_callback'
# Configuration end

r = praw.Reddit('LiveStyle v0.1 by /u/Timbo_KZ')
r.set_oauth_app_info(client_id=clientID, client_secret=clientSecret, redirect_uri=clientCallback)
r.login(username, password)


def file_get_contents(filename):
    with open(filename) as f:
        return f.read()


def static_var(varname, value):
    def decorate(func):
        setattr(func, varname, value)
        return func

    return decorate


@static_var("oldStylesheet", "")
def update_stylesheet():
    prefix = "[" + time.strftime("%I:%M:%S") + ", " + subredditName + "] "
    threading.Timer(2.0, update_stylesheet).start()
    print(prefix + "Checking CSS...")
    stylesheet = file_get_contents(stylesheetPath)
    if stylesheet != update_stylesheet.oldStylesheet:
        print(prefix + "Updating CSS...")
        r.set_stylesheet(subredditName, stylesheet)
        update_stylesheet.oldStylesheet = stylesheet
    else:
        print(prefix + "CSS is up to date.")


update_stylesheet()
