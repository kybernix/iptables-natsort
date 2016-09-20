# iptables-natsort

iptables entity natsort, usage is same as iptables-save.

##requires
-php5~
-iptables

##notice
-make sure backup iptables, before use this.
-ACCEPT rules are treated as top priority.

##usage
showing sorted result:
<pre>
	php iptables-natsort.php
</pre>
saving sorted result:
<pre>
	php iptables-natsort.php > /etc/sysconfig/iptables
</pre>

##sample result
before:
<pre>
	*filter
	:INPUT ACCEPT
	:OUTPUT ACCEPT
	-A INPUT -s 1.1.1.0/24 -j DROP
	-A INPUT -s 4.3.2.0/21 -j DROP
	-A INPUT -s 2.201.0.0/16 -j DROP
	-A INPUT -s 2.102.0.0/15 -j DROP
	COMMIT
</pre>

after:
<pre>
	*filter
	:INPUT ACCEPT
	:OUTPUT ACCEPT
	-A INPUT -s 1.1.1.0/24 -j DROP
	-A INPUT -s 2.102.0.0/15 -j DROP
	-A INPUT -s 2.201.0.0/16 -j DROP
	-A INPUT -s 4.3.2.0/21 -j DROP
	COMMIT
</pre>
