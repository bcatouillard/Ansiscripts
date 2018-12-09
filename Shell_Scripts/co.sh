#!/usr/bin/expect -f

set pass [lindex $argv 1]
set server [lindex $argv 0]
set name root

spawn ssh-copy-id -i /root/.ssh/id_rsa.pub $name@$server
match_max 100
expect "*(yes/no)?*" {
	send "yes\r"
	}
expect "*assword:*" {
	send -- "$pass\r"
	}
send -- "\r"
interact
