<?php 

require_once 'LogHandler.php';
require_once('StreamWriter.php');
require_once 'MongoWriter.php';

$log = new Spector_Log();

$log->setProject('test');
$log->setEnvironment('dev');

$log->addWriter(new Spector_StreamWriter('php://output', Spector_StreamWriter::FORMAT_READABLE));

$connection = new Mongo('server.theduke.at');
$log->addWriter(new Spector_MongoWriter($connection, 'spector_test'));

Spector_LogHandler::setLog($log);

Spector_LogHandler::log('Testnachricht', Spector_LogEntry::CRITICAL);
Spector_LogHandler::log('Lala 2', Spector_LogEntry::DEBUG);
