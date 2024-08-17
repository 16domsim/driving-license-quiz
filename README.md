# Driving License Quiz

A PHP-based web application designed to help users practice for their driving license test I made as part of a school project in 2020. The application manages quizzes an user authentication and stores the data using MySQL. 
I used German througout all of this project, thus I will explain the functionality in German.

## Funktionalität

Diese Anwendung bietet eine umfassende und benutzerfreundliche Lösung zur Vorbereitung auf die theoretische Fahrprüfung. Hier sind die Hauptfunktionen im Detail:

### 1. **Fragenverwaltung**

- **Fragen erstellen und bearbeiten**: Administratoren neue Fragen zur Datenbank hinzufügen oder bestehende Fragen bearbeiten. Jede Frage kann mehreren Kategorien zugeordnet werden, um eine gezielte Prüfungsvorbereitung zu ermöglichen.
- **Antworten zu Fragen verwalten**: Es ist möglich mehrere Antwortmöglichkeiten für jede Frage zu definieren und die korrekte Antwort festzulegen.

### 2. **Quiz-System**

- **Quiz erstellen und verwalten**: Administratoren können neue Quizze erstellen, die aus einer zufälligen oder benutzerdefinierten Auswahl von Fragen bestehen.
- **Fragen anzeigen und beantworten**: Der Benutzer hat die Möglichkeit, durch die Fragen zu navigieren und Antworten auszuwählen. Nach Abschluss des Quiz werden die Ergebnisse automatisch gespeichert und der Benutzer erhält sofortiges Feedback.

### 3. **Benutzerauthentifizierung**

- **Sicheres Anmelden und Registrieren**: Die Authentifizierung stellt sicher, dass nur berechtigte Benutzer auf die Quizze und persönlichen Fortschrittsdaten zugreifen können.
- **Passwortschutz**: Benutzerdaten werden in einer MySQL-Datenbank gespeichert, wobei Passwörter sicher verschlüsselt werden, um den Datenschutz zu gewährleisten.

### 4. **Ergebnisübersicht**

- **Ergebnisse speichern und anzeigen**: Benutzer können ihre Fortschritte verfolgen und sehen, welche Fragen sie richtig oder falsch beantwortet haben.


### 5. **Datenbankinteraktion**

- **Datenbankoperationen**: Alle Daten werden in einer MySQL-Datenbank gespeichert und verwaltet. Die Anwendung nutzt SQL-Abfragen, um Daten effizient zu speichern, abzurufen und zu aktualisieren.

