import 'package:flutter/material.dart';

class CustomerHomeScreen extends StatelessWidget {
  const CustomerHomeScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('PearlHub Customer')),
      body: ListView(
        padding: const EdgeInsets.all(16),
        children: <Widget>[
          Card(child: ListTile(title: Text('Concierge'), subtitle: Text('Plan a cross-vertical booking'))),
          Card(child: ListTile(title: Text('My Escrow Orders'), subtitle: Text('Track holds and releases'))),
          Card(child: ListTile(title: Text('PearlPoints'), subtitle: Text('View loyalty balance and rewards'))),
          Card(child: ListTile(title: Text('Livestream Deals'), subtitle: Text('Join live shopping sessions and checkout instantly'))),
          Card(child: ListTile(title: Text('Voice Booking'), subtitle: Text('Use Sinhala, Tamil, or English voice to search and book'))),
          Card(child: ListTile(title: Text('Resale Marketplace'), subtitle: Text('Browse sustainable second-life premium inventory'))),
          Card(child: ListTile(title: Text('Pearl Academy'), subtitle: Text('Learn travel, booking, and service quality best practices'))),
        ],
      ),
    );
  }
}
