INSERT INTO `iris_formulieren` (`hash`, `naam`, `active`, `onderwerpregel`, `tekst`, `aan`, `cc`, `bcc`, `bevestiging_onderwerpregel`, `bevestiging_tekst`, `bevestiging_versturen`, `bevestiging_ontvanger_veld`, `bedankttekst`, `doorsturen_naar`, `knop_tekst`, `addon`, `created`, `modified`, `options`) VALUES
('03f777dc-1dde-4590-b302-6964968b27b4', 'Contactformulier', 'ja', 'Contact via de website', 'Beste,<br><br>Het contactformulier op uw website is ingevuld. Hieronder de gegevens.<br><br>{{formulier}}<br><br>Met vriendelijke groet,<br>{{APP_NAME}}', '[\"development@themindoffice.nl\"]', NULL, NULL, 'We hebben uw bericht ontvangen', 'Beste {{864678cf-3cbd-4215-84b1-f2e4fd75dc7b}},<br><br>We hebben uw bericht ontvangen. Hieronder nog even de gegevens.<br><br>{{formulier}}<br><br>Met vriendelijke groet,<br>{{APP_NAME}}', 1, 3, 'Uw bericht is verzonden', NULL, 'Versturen', NULL, UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), '{\"couples\":{\"iris_formulieren_velden\":{\"enabled\":true}}}');
