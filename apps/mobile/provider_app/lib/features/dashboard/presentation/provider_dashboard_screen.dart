import 'package:flutter/material.dart';

class ProviderDashboardScreen extends StatelessWidget {
  const ProviderDashboardScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('PearlHub Provider')),
      body: ListView(
        padding: const EdgeInsets.all(16),
        children: const <Widget>[
          Card(child: ListTile(title: Text('Listings Moderation'), subtitle: Text('Draft to publish workflow'))),
          Card(child: ListTile(title: Text('Bookings Queue'), subtitle: Text('Upcoming and active orders'))),
          Card(child: ListTile(title: Text('Payouts'), subtitle: Text('Escrow release settlements'))),
        ],
      ),
    );
  }
}
