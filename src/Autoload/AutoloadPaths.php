<?php

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * AutoloadPaths
 * Wrapper class to hold information of class-paths.
 * Value of AutoloadPaths::$paths is created by call
 * of Autoload::make().
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage autoload 
 */

use PEIP\Dispatcher\EventClassDispatcher;
use PEIP\Dispatcher\ObjectMapDispatcher;
use PEIP\Dispatcher\ClassDispatcher;
use PEIP\Dispatcher\ObjectEventDispatcher;
use PEIP\Dispatcher\ClassEventDispatcher;
use PEIP\Dispatcher\MapDispatcher;
use PEIP\Dispatcher\Dispatcher;
use PEIP\Dispatcher\IteratingDispatcher;
use PEIP\Event\EventBuilder;
use PEIP\Event\Event;
use PEIP\Event\Observable;
use PEIP\Channel\DirectChannel;
use PEIP\Channel\PublishSubscribeChannel;
use PEIP\Channel\MessageChannel;
use PEIP\Channel\ChannelRegistry;
use PEIP\Channel\QueueChannel;
use PEIP\Channel\PollableChannel;
use PEIP\Channel\PriorityChannel;
use PEIP\Channel\ChannelAdapter;
use PEIP\Translator\XMLArrayTranslator;
use PEIP\Pipe\SimpleFixedEventPipe;
use PEIP\Pipe\Pipe;
use PEIP\Pipe\FixedEventPipe;
use PEIP\Pipe\EventPipe;
use PEIP\Pipe\SimpleEventPipe;
use PEIP\Pipe\CommandPipe;
use PEIP\Handler\CallableHandler;
use PEIP\Command\Command;
use PEIP\Data\ParameterHolderCollection;
use PEIP\Data\ParameterCollection;
use PEIP\Data\InternalStoreAbstract;
use PEIP\Data\StoreCollection;
use PEIP\Data\Store;
use PEIP\Data\ArrayAccess;
use PEIP\Data\ParameterHolder;
use PEIP\Service\ServiceContainer;
use PEIP\Service\SplittingServiceActivator;
use PEIP\Service\ServiceActivator;
use PEIP\Service\ServiceContainerBuilder;
use PEIP\Service\HeaderServiceActivator;
use PEIP\Service\ServiceProvider;
use PEIP\Service\StringServiceActivator;
use PEIP\Factory\ServiceFactory;
use PEIP\Factory\DedicatedFactory;
use PEIP\Gateway\SimpleMessagingGateway;
use PEIP\Selector\ContentClassSelector;
use PEIP\Selector\ContentTypeSelector;
use PEIP\Util\ReflectionPool;
use PEIP\Util\Test;
use PEIP\Util\Reflection;
use PEIP\Base\VisitableArray;
use PEIP\Base\Sealer;
use PEIP\Base\ObjectStorage;
use PEIP\Base\DynamicAdapter;
use PEIP\Base\GenericBuilder;
use PEIP\Base\ReflectionClassBuilder;
use PEIP\Base\FlyAdapter;
use PEIP\Message\CallableMessageHandler;
use PEIP\Message\TextMessage;
use PEIP\Message\MessageBuilder;
use PEIP\Message\ErrorMessage;
use PEIP\Message\GenericMessage;
use PEIP\Message\CommandMessage;
use PEIP\Message\StringMessage;
use PEIP\Context\XMLContextReader;
use PEIP\Context\XMLContext;
use PEIP\Plugins\BasePlugin;
use PEIP\Listener\Wiretap;

namespace PEIP\Autoload;

class AutoloadPaths {

    // please, dont�t edit these lines manually
    // use Autoload::make() instead
    public static $paths = array (
  'PEIP\ABS\Aggregator\MessageBarrierHandler' => '/ABS/aggregator/PEIP\ABS\Aggregator\MessageBarrierHandler.php',
  'PEIP\ABS\Router\Router' => '/ABS/router/PEIP\ABS\Router\Router.php',
  'PEIP\ABS\Dispatcher\MapDispatcher' => '/ABS/dispatcher/PEIP\ABS\Dispatcher\MapDispatcher.php',
  'PEIP\ABS\Dispatcher\Dispatcher' => '/ABS/dispatcher/PEIP\ABS\Dispatcher\Dispatcher.php',
  'PEIP\ABS\Channel\SubscribableChannel' => '/ABS/channel/PEIP\ABS\Channel\SubscribableChannel.php',
  'PEIP\ABS\Channel\PollableChannel' => '/ABS/channel/PEIP\ABS\Channel\PollableChannel.php',
  'PEIP\ABS\Channel\Channel' => '/ABS/channel/PEIP\ABS\Channel\Channel.php',
  'PEIP\ABS\Splitter\MessageSplitter' => '/ABS/splitter/PEIP\ABS\Splitter\MessageSplitter.php',
  'PEIP\ABS\Pipe\EventPipe' => '/ABS/pipe/PEIP\ABS\Pipe\EventPipe.php',
  'PEIP\ABS\Handler\MessageHandler' => '/ABS/handler/PEIP\ABS\Handler\MessageHandler.php',
  'PEIP\ABS\Handler\ReplyProducingMessageHandler' => '/ABS/handler/PEIP\ABS\Handler\ReplyProducingMessageHandler.php',
  'PEIP\ABS\Handler\DiscardingMessageHandler' => '/ABS/handler/PEIP\ABS\Handler\DiscardingMessageHandler.php',
  'PEIP\ABS\Command\Command' => '/ABS/command/PEIP\ABS\Command\Command.php',
  'PEIP\ABS\Transformer\ContentTransformer' => '/ABS/transformer/PEIP\ABS\Transformer\ContentTransformer.php',
  'PEIP\ABS\Transformer\Transformer' => '/ABS/transformer/PEIP\ABS\Transformer\Transformer.php',
  'PEIP\ABS\Service\ServiceActivator' => '/ABS/service/PEIP\ABS\Service\ServiceActivator.php',
  'PEIP\ABS\Base\MutableContainer' => '/ABS/base/PEIP\ABS\Base\MutableContainer.php',
  'PEIP\ABS\Base\Connectable' => '/ABS/base/PEIP\ABS\Base\Connectable.php',
  'PEIP\ABS\Base\Container' => '/ABS/base/PEIP\ABS\Base\Container.php',
  'PEIP\ABS\Request\Connection' => '/ABS/request/PEIP\ABS\Request\Connection.php',
  'PEIP\ABS\Request\Request' => '/ABS/request/PEIP\ABS\Request\Request.php',
  'PEIP\ABS\Context\ContextPlugin' => '/ABS/context/PEIP\ABS\Context\ContextPlugin.php',
  'EventClassDispatcher' => '/dispatcher/EventClassDispatcher.php',
  'ObjectMapDispatcher' => '/dispatcher/ObjectMapDispatcher.php',
  'ClassDispatcher' => '/dispatcher/ClassDispatcher.php',
  'ObjectEventDispatcher' => '/dispatcher/ObjectEventDispatcher.php',
  'ClassEventDispatcher' => '/dispatcher/ClassEventDispatcher.php',
  'MapDispatcher' => '/dispatcher/MapDispatcher.php',
  'Dispatcher' => '/dispatcher/Dispatcher.php',
  'IteratingDispatcher' => '/dispatcher/IteratingDispatcher.php',
  'EventBuilder' => '/event/EventBuilder.php',
  'Event' => '/event/Event.php',
  'Observable' => '/event/Observable.php',
  'DirectChannel' => '/channel/DirectChannel.php',
  'PublishSubscribeChannel' => '/channel/PublishSubscribeChannel.php',
  'MessageChannel' => '/channel/MessageChannel.php',
  'ChannelRegistry' => '/channel/ChannelRegistry.php',
  'QueueChannel' => '/channel/QueueChannel.php',
  'PollableChannel' => '/channel/PollableChannel.php',
  'PriorityChannel' => '/channel/PriorityChannel.php',
  'ChannelAdapter' => '/channel/ChannelAdapter.php',
  'XMLArrayTranslator' => '/translator/XMLArrayTranslator.php',
  'SimpleFixedEventPipe' => '/pipe/SimpleFixedEventPipe.php',
  'Pipe' => '/pipe/Pipe.php',
  'FixedEventPipe' => '/pipe/FixedEventPipe.php',
  'Event_Pipe' => '/pipe/Event_Pipe.php',
  'SimpleEventPipe' => '/pipe/SimpleEventPipe.php',
  'CommandPipe' => '/pipe/CommandPipe.php',
  'CallableHandler' => '/handler/CallableHandler.php',
  'Command' => '/command/Command.php',
  'ParameterHolderCollection' => '/data/ParameterHolderCollection.php',
  'ParameterCollection' => '/data/ParameterCollection.php',
  'InternalStoreAbstract' => '/data/InternalStoreAbstract.php',
  'StoreCollection' => '/data/StoreCollection.php',
  'Store' => '/data/Store.php',
  'ArrayAccess' => '/data/ArrayAccess.php',
  'ParameterHolder' => '/data/ParameterHolder.php',
  'ServiceContainer' => '/service/ServiceContainer.php',
  'SplittingServiceActivator' => '/service/SplittingServiceActivator.php',
  'ServiceActivator' => '/service/ServiceActivator.php',
  'ServiceContainer_Builder' => '/service/ServiceContainer_Builder.php',
  'HeaderServiceActivator' => '/service/HeaderServiceActivator.php',
  'ServiceProvider' => '/service/ServiceProvider.php',
  'StringServiceActivator' => '/service/StringServiceActivator.php',
  'ServiceFactory' => '/factory/ServiceFactory.php',
  'DedicatedFactory' => '/factory/DedicatedFactory.php',
  'PEIP' => '/PEIP.php',
  'SimpleMessagingGateway' => '/gateway/SimpleMessagingGateway.php',
  'PEIP\INF\Aggregator\CompletionStrategy' => '/INF/aggregator/PEIP\INF\Aggregator\CompletionStrategy.php',
  'PEIP\INF\Aggregator\CorrelationStrategy' => '/INF/aggregator/PEIP\INF\Aggregator\CorrelationStrategy.php',
  'PEIP\INF\Dispatcher\BreakableDispatcher' => '/INF/dispatcher/PEIP\INF\Dispatcher\BreakableDispatcher.php',
  'PEIP\INF\Dispatcher\ObjectMapDispatcher' => '/INF/dispatcher/PEIP\INF\Dispatcher\ObjectMapDispatcher.php',
  'PEIP\INF\Dispatcher\MapDispatcher' => '/INF/dispatcher/PEIP\INF\Dispatcher\MapDispatcher.php',
  'PEIP\INF\Dispatcher\ListDispatcher' => '/INF/dispatcher/PEIP\INF\Dispatcher\ListDispatcher.php',
  'PEIP\INF\Dispatcher\Dispatcher' => '/INF/dispatcher/PEIP\INF\Dispatcher\Dispatcher.php',
  'PEIP\INF\Event\EventHandler' => '/INF/event/PEIP\INF\Event\EventHandler.php',
  'PEIP\INF\Event\EventDispatcher' => '/INF/event/PEIP\INF\Event\EventDispatcher.php',
  'PEIP\INF\Event\EventPublisher' => '/INF/event/PEIP\INF\Event\EventPublisher.php',
  'PEIP\INF\Event\Listener' => '/INF/event/PEIP\INF\Event\Listener.php',
  'PEIP\INF\Event\Event' => '/INF/event/PEIP\INF\Event\Event.php',
  'PEIP\INF\Event\Observable' => '/INF/event/PEIP\INF\Event\Observable.php',
  'PEIP\INF\Event\Connectable' => '/INF/event/PEIP\INF\Event\Connectable.php',
  'PEIP\INF\Event\Observer' => '/INF/event/PEIP\INF\Event\Observer.php',
  'PEIP\INF\Channel\ChannelResolver' => '/INF/channel/PEIP\INF\Channel\ChannelResolver.php',
  'PEIP\INF\Channel\PollableChannel' => '/INF/channel/PEIP\INF\Channel\PollableChannel.php',
  'PEIP\INF\Channel\Channel' => '/INF/channel/PEIP\INF\Channel\Channel.php',
  'PEIP\INF\Channel\SubscribableChannel' => '/INF/channel/PEIP\INF\Channel\SubscribableChannel.php',
  'PEIP\INF\Handler\Handler' => '/INF/handler/PEIP\INF\Handler\Handler.php',
  'PEIP\INF\Command\Command' => '/INF/command/PEIP\INF\Command\Command.php',
  'PEIP\INF\Command\ParametricCommand' => '/INF/command/PEIP\INF\Command\ParametricCommand.php',
  'PEIP\INF\Transformer\Transformer' => '/INF/transformer/PEIP\INF\Transformer\Transformer.php',
  'PEIP\INF\Data\StoreCollection' => '/INF/data/PEIP\INF\Data\StoreCollection.php',
  'PEIP\INF\Data\ParameterHolder' => '/INF/data/PEIP\INF\Data\ParameterHolder.php',
  'PEIP\INF\Data\ParameterHolder_Collection' => '/INF/data/PEIP\INF\Data\ParameterHolder_Collection.php',
  'PEIP\INF\Data\Store' => '/INF/data/PEIP\INF\Data\Store.php',
  'PEIP\INF\Service\ServiceContainer' => '/INF/service/PEIP\INF\Service\ServiceContainer.php',
  'PEIP\INF\Service\ServiceActivator' => '/INF/service/PEIP\INF\Service\ServiceActivator.php',
  'PEIP\INF\Factory\DedicatedFactory' => '/INF/factory/PEIP\INF\Factory\DedicatedFactory.php',
  'PEIP\INF\Gateway\MessagingGateway' => '/INF/gateway/PEIP\INF\Gateway\MessagingGateway.php',
  'PEIP\INF\Selector\MessageSelector' => '/INF/selector/PEIP\INF\Selector\MessageSelector.php',
  'PEIP\INF\Base\Lifecycle' => '/INF/base/PEIP\INF\Base\Lifecycle.php',
  'PEIP\INF\Base\SingletonMap' => '/INF/base/PEIP\INF\Base\SingletonMap.php',
  'PEIP\INF\Base\SingletonArgs' => '/INF/base/PEIP\INF\Base\SingletonArgs.php',
  'PEIP\INF\Base\Identifier' => '/INF/base/PEIP\INF\Base\Identifier.php',
  'PEIP\INF\Base\MutableContainer' => '/INF/base/PEIP\INF\Base\MutableContainer.php',
  'PEIP\INF\Base\Singleton' => '/INF/base/PEIP\INF\Base\Singleton.php',
  'PEIP\INF\Base\Visitor' => '/INF/base/PEIP\INF\Base\Visitor.php',
  'PEIP\INF\Base\SingletonMap_Array' => '/INF/base/PEIP\INF\Base\SingletonMap_Array.php',
  'PEIP\INF\Base\Visitable' => '/INF/base/PEIP\INF\Base\Visitable.php',
  'PEIP\INF\Base\Plugable' => '/INF/base/PEIP\INF\Base\Plugable.php',
  'PEIP\INF\Base\Filter' => '/INF/base/PEIP\INF\Base\Filter.php',
  'PEIP\INF\Base\Document' => '/INF/base/PEIP\INF\Base\Document.php',
  'PEIP\INF\Base\Container' => '/INF/base/PEIP\INF\Base\Container.php',
  'PEIP\INF\Base\Unsealer' => '/INF/base/PEIP\INF\Base\Unsealer.php',
  'PEIP\INF\Base\Buildable' => '/INF/base/PEIP\INF\Base\Buildable.php',
  'PEIP\INF\Base\Sealer' => '/INF/base/PEIP\INF\Base\Sealer.php',
  'PEIP\INF\Request\Request' => '/INF/request/PEIP\INF\Request\Request.php',
  'PEIP\INF\Request\Connection' => '/INF/request/PEIP\INF\Request\Connection.php',
  'PEIP\INF\Message\MessageHandler' => '/INF/message/PEIP\INF\Message\MessageHandler.php',
  'PEIP\INF\Message\MessageChannel' => '/INF/message/PEIP\INF\Message\MessageChannel.php',
  'PEIP\INF\Message\HeaderEnricher' => '/INF/message/PEIP\INF\Message\HeaderEnricher.php',
  'PEIP\INF\Message\Message' => '/INF/message/PEIP\INF\Message\Message.php',
  'PEIP\INF\Message\Message_Sender' => '/INF/message/PEIP\INF\Message\Message_Sender.php',
  'PEIP\INF\Message\Message_Builder' => '/INF/message/PEIP\INF\Message\Message_Builder.php',
  'PEIP\INF\Message\PollableMessageChannel' => '/INF/message/PEIP\INF\Message\PollableMessageChannel.php',
  'PEIP\INF\Message\EnvelopeMessage' => '/INF/message/PEIP\INF\Message\EnvelopeMessage.php',
  'PEIP\INF\Message\StringMessage' => '/INF/message/PEIP\INF\Message\StringMessage.php',
  'PEIP\INF\Message\Message_Dispatcher' => '/INF/message/PEIP\INF\Message\Message_Dispatcher.php',
  'PEIP\INF\Message\Message_Receiver' => '/INF/message/PEIP\INF\Message\Message_Receiver.php',
  'PEIP\INF\Message\Message_Source' => '/INF/message/PEIP\INF\Message\Message_Source.php',
  'PEIP\INF\Context\ContextPlugin' => '/INF/context/PEIP\INF\Context\ContextPlugin.php',
  'PEIP\INF\Context\Context' => '/INF/context/PEIP\INF\Context\Context.php',
  'ContentClassSelector' => '/selector/ContentClassSelector.php',
  'ContentTypeSelector' => '/selector/ContentTypeSelector.php',
  'ReflectionPool' => '/util/ReflectionPool.php',
  'Test' => '/util/Test.php',
  'Reflection' => '/util/Reflection.php',
  'VisitableArray' => '/base/VisitableArray.php',
  'Sealer' => '/base/Sealer.php',
  'ObjectStorage' => '/base/ObjectStorage.php',
  'DynamicAdapter' => '/base/DynamicAdapter.php',
  'GenericBuilder' => '/base/GenericBuilder.php',
  'Reflection_Class_Builder' => '/base/Reflection_Class_Builder.php',
  'FlyAdapter' => '/base/FlyAdapter.php',
  'CallableMessageHandler' => '/message/CallableMessageHandler.php',
  'TextMessage' => '/message/TextMessage.php',
  'MessageBuilder' => '/message/MessageBuilder.php',
  'ErrorMessage' => '/message/ErrorMessage.php',
  'GenericMessage' => '/message/GenericMessage.php',
  'Command_Message' => '/message/Command_Message.php',
  'StringMessage' => '/message/StringMessage.php',
  'XMLContextReader' => '/context/XMLContextReader.php',
  'XMLContext' => '/context/XMLContext.php',
  'BasePlugin' => '/plugins/BasePlugin.php',
  'SimpleAutoload' => '/autoload/SimpleAutoload.php',
  'Autoload' => '/autoload/Autoload.php',
  'AutoloadPaths' => '/autoload/AutoloadPaths.php',
  'Wiretap' => '/listener/Wiretap.php',
);
    
}
