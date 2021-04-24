#!/usr/bin/python3
import idna
import re
import sys
import cgi




def normalize_domain(domain_name):
    domain_name = domain_name.replace('1', '۱')
    domain_name = domain_name.replace('2', '۲')
    domain_name = domain_name.replace('3', '۳')
    domain_name = domain_name.replace('4', '۴')
    domain_name = domain_name.replace('5', '۵')
    domain_name = domain_name.replace('6', '۶')
    domain_name = domain_name.replace('7', '۷')
    domain_name = domain_name.replace('8', '۸')
    domain_name = domain_name.replace('9', '۹')
    domain_name = domain_name.replace('0', '۰')
    domain_name = domain_name.replace('٠', '۰')
    domain_name = domain_name.replace('١', '۱')
    domain_name = domain_name.replace('٢', '۲')
    domain_name = domain_name.replace('٣', '۳')
    domain_name = domain_name.replace('٤', '۴')
    domain_name = domain_name.replace('٥', '۵')
    domain_name = domain_name.replace('٦', '۶')
    domain_name = domain_name.replace('٧', '۷')
    domain_name = domain_name.replace('٨', '۸')
    domain_name = domain_name.replace('٩', '۹')
    domain_name = domain_name.replace('ي', 'ی')
    domain_name = domain_name.replace('ك', 'ک')
    return domain_name


persian_letters = "آاءأبپتثجچحخدذرزژسشصضطظعغفقکگلمنوؤهةیئيك"
persian_numbers = "0123456789٠١٢٣٤٥٦٧٨٩۰۱۲۳۴۵۶۷۸۹"
persian_numbers_only = "۰۱۲۳۴۵۶۷۸۹"
persian_right_join = 'اأدذرزژوؤةآ'
persian_dual_join = 'بپتثجچحخسشصضطظعغفقکگلمنهیئيك'
persian_non_join = '\u200cء'
tld = '.ایران'
#domain = 'سازمان‌فن‌آوری‌اطلاعات'


#prog = re.compile('^['+persian_letters+']+\u200c?['+persian_letters+']*\d*['+persian_letters+']*$')
allowed_char = re.compile('^['+persian_letters+'\u200c'+persian_numbers+'-]+$')

wle_1 = re.compile(u'^['+persian_letters+']')
wle_2 = re.compile(u'^['+persian_letters+'].*(?:['+persian_letters+']|['+persian_numbers+'])$')
wle_3 = re.compile(u'[-]{2,}')
wle_4 = re.compile(u'[\u002d'+persian_numbers+persian_right_join+persian_non_join+'][\u200c]')
wle_5 = re.compile(u'[\u200c][\u002d'+persian_numbers+persian_non_join+']')
#domains = sys.stdin.readlines()
print("Content-type: text/html\r\n\r\n") 
print("<html><head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'/><body>") 
print("<h1> Compiled names </h1>") 
form = cgi.FieldStorage()
if form.getvalue("comment"):
    domains = form.getvalue("comment").splitlines()
    for domain in domains:
        flag = 0
        domain = domain.replace("\n","")
        if allowed_char.match(domain):
            if(wle_1.search(domain)):
                if(wle_2.search(domain)):
                    if not (wle_3.search(domain)):
                        if not (wle_4.search(domain)):
                            if not (wle_5.search(domain)):
                                flag = 1
                                print( "<p style='color:blue'><b>" + domain + ":</b>   {") 
                                for char in domain:
                                    print(char.encode("unicode_escape").decode('utf-8').replace('\\u','U+').upper())
                                print("}</p>")
                                domain = normalize_domain(domain)
                                print("<p>"+idna.encode(domain+tld).decode('utf-8'),'#'+domain+tld+"</p>")
                                if re.search(u'\u200c', domain):
                                    print("<p>"+idna.encode(domain.replace('\u200c', '')+tld).decode('utf-8'), '#'+domain.replace('\u200c', '')+tld+"</p>")
                                    print("<p>"+idna.encode(domain.replace('\u200c', '-') + tld).decode('utf-8'), '#'+domain.replace('\u200c', '-')+tld+"</p>")
                                print ("<hr>");

        if flag != 1:
            print( "<p style='color:red'><b>" + domain + ":</b>   {") 
            for char in domain:
                print(char.encode("unicode_escape").decode('utf-8').replace('\\u','U+').upper())
            print("}</p>")

print("<h1> List domains below each domain per line (NO TLD) </h1>") 
print("<textarea form='usrdomain' name='comment' cols='50' rows= '20'  id='usrcomment'></textarea>")
print("<form method='post' action='label-regexp.py' id='usrdomain'>")
print("<p><input type='submit'/></p>")
print("</form") 
print("</body></html>") 
