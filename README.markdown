<h1>PEIP - PHP Event Integration Project</h1>
<small><em>pronounced: pipe</em></small><br><br>
<em>The first Event Driven Messaging Framework (for PHP)</em>
<h2>PREFACE</h2>
Let your Database speak to your Chat-App<br>
Make your MVC concentrate on its job<br>
Design your Workflow without any headache<br>
Let your Mobile talk with your Blog<br><br>

Let your Mailserver twitter to Facebook<br>
Update your Offline-App on connect<br>
Free your Controller from making choices<br> 
Let your Dependencies off the Hook<br><br>

Let your CRM talk to Twitter<br>
Make your Config Context aware<br>
Route your Custom-Events through the Pipeline<br>
Make your Messages easy to share<br><br>

Transform your Documents to any Format<br>
Forgett about Coupling and Vendor-Locks<br>
On Demand build your Index and Caches<br>
And if you want to, Change all of that!<br><br>

<h2>WHERE?</h2>
You can find PEIP큦 <a href="http://www.peip.org">(interim) Homepage here</a><br>
You can find PEIP큦 <a href="http://github.com/tidal/PEIP">GitHub-Page here</a><br>
You can find PEIP큦 <a href="http://github.com/tidal/PEIP/downloads">downloads here</a><br>
You can find PEIP큦 <a href="http://pear.peip.org/">PEAR packages here</a><br>
You can find PEIP큦 <a href="http://tidal.github.com/PEIP/docs/api/latest/classes.html">API docs here</a><br>
You can find PEIP큦 <a href="http://github.com/tidal/PEIP/tree/master/examples/">Examples in the Source</a>.<br>
You can find PEIP큦 <a href="http://tidal.lighthouseapp.com/projects/50364-peip/tickets">Issue/Bug Tracker here</a><br>
You can find PEIP큦 <a href="http://www.ohloh.net/p/peip">ohloh metrics  here</a><br>

<h2>WHAT?</h2>

PEIP is a pure PHP Middleware Framework to easily create and connect Messaging- and Work-Flows.<br>
One of PEIP's goals is to provide implementations of <a href="http://www.eaipatterns.com/eaipatterns.html">Enterprise Integration Patterns</a> for PHP (but with a bit different approach then usually).<br>
PEIP can be used by scripting or configuration (recommended).<br>
PEIP is noninvasive - it plays nicely and integrates with your favorite MVC, Library, Services or PHP Applications.<br> 
PEIP is Event Driven. This allows for easily combining it's components without a need for coupling.<br> 
PEIP's Event Objects are first class Messages and can travel through the same components as Generic Messages.<br> 
PEIP can be easily extended and integrated (by using its interfaces).<br>
PEIP's configuration (ability) can be easily augmented by simple plugins.<br><br>
PEIP's main Components are:<br>
<h3>Messages</h3>
Messages are basically generic wrappers for PHP Objects or any other type (strings, integers, arrays, ...).<br>
Messages contain special header fields to provide meta data/information. For example: a return address (channel).
<h3>Events</h3>
Event Objects are special Messages which are created on certain incedents on PEIP components.<br>
Events Objects wrap the object where the event happend and can provide further data in headers.<br>
Since Event Objects are first class Messages, they can travell through the messaging system to allow further processing.<br>
Event Objects are only created when there is a listener registered for the certain event-type on the object. (So no 'event-spamming')
<h3>Channels</h3>
(Message) Channels are the objects on which Messages can be send and received from<br>
A Producer would send a Message and a Consumer would receive it.<br>
Basically there are two types of Channels:<br>
<em>(Note, that in implementation there is also a difference in how the Messages are received - that is publishing vs. polling)</em>
<h4>Point-to-Point Channels</h4>
A Point-to-Point Channel (for example a PollableChannel) let exactly one Consumer receive a certain Message<br>
<h4>Publish-Subscribe Channels</h4>
A Publish-Subscribe Channel broadcasts any Message to all of its subscribers.  
<h3>Pipes</h3>
Pipes are PEIP's most powerfull components.<br>
They are not to be mixed up with "pipes" in a "pipes-and-filters architecture" - That would be the Channels.<br>
Instead Pipes in PEIP are pipes-and-filters combinded in one. They can act as a filter (or router, splitter, aggregator, ...),<br>
Message-Handler and can be hooked up in any place, where actually a channel would be needed.<br> Hence Pipes can be chained together without the need for channels to connect them.<br>
Pipes are the base component for any component handling, examining, manipulating or routing messages.<br><br>
A special sub-type of Pipes are EventPipes:<br>
EventPipes can be hooked up on any component implementing the Connectable (Event-Publisher) Interface and pass its <br>
EventObjects to the Messaging System for further routing or processing.
<h3>Service Activators</h3>
ServiceActivators are Adapters to decouple your Services from the Messaging System.<br> 
Service as used in PEIP does mean any arbitrary object instance which may can be manipulated before<br>
calling a certain method on it, hence it'd fit with any of your typically used objects (including webservices). <br>
(In Java-land service in this case would refer to a bean, but since we are talking about PHP-land there <br>
are no beans - you could call them Peas if you like.) 
<h3>Gateways</h3>
(Message) Gateways are Adapters to decouple the entry to the Messaging System.<br>
They will take care of creating Message Objects from abritrary inputs and send them on an appropriate channel.<br>
On the output-level a Gateway will extract data from the received messages and pass it to a caller.<br>
Gateways can be designed to mimick the API of your existing application, framework or library.   

<h2>WHY?</h2>

soon to follow<br>

<h2>HOW?</h2>

soon to follow<br>
API docs can be found <a href="http://tidal.github.com/PEIP/docs/api/latest/classes.html">here</a><br>
See also exmple section in source code

<h2>REQUIREMENTs:</h2>
PEIP needs PHP5.3 to run.<br>
This requirement came out while developing PEIP and is mostly based on the usage of inline functions<br>
(Lamdas/Closures), the use of SplObjectStorage and some usage of late static binding.<br>
So the reason why there are no Namespaces used in PEIP is because the PHP5.3 dependency crept in <br>
while developing. (This may change in future).<br>
Also PEIP could be backported to be able to be used with lower PHP5 versions. While there is actually<br>
no plan to do this, it would not be so hard (but worse performing), because the 5.3 dependencies are <br>
not used in to many places.     
<h3>SPECIAL REQUIREMENTs:</h3>
Since PEIP is to be used with a variety of Applications, Frameworks and Services there might be special
dependencies to use them with PEIP<br>
For example the PEIP Gearman extension (PEIP_Gearman) has a dependency on PHP's Gearman extension and a Gearman server.

<h2>INSTALLATION:</h2>    
<h3>PEAR Install</h3>
run:<br>
pear channel-discover pear.peip-project.de<br>
pear install peip/peip
<h3>Install From Download</h3>
Download source from Downloads <a href="http://github.com/tidal/PEIP/downloads">http://github.com/tidal/PEIP/downloads</a><br>
Extract file to your include directory.
<h3>Install From Source</h3>
Change to one of your include directories.<br>
run:<br>
git clone git://github.com/tidal/PEIP.git 

<h2>See also:</h2> 
<br>
<a href="http://github.com/tidal/PEIP_Gearman">PEIP Gearman Extension</a><br> 
<a href="http://github.com/tidal/PEIP-Editor">Proof Of Concept: Visual Web-Editor for PEIP</a><br>
<br><br><br><br>





