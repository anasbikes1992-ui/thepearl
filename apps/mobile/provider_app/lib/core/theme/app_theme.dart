import 'package:flutter/material.dart';

ThemeData providerTheme() {
  return ThemeData(
    useMaterial3: true,
    scaffoldBackgroundColor: const Color(0xFFF8F1E3),
    colorScheme: const ColorScheme.light(
      primary: Color(0xFF0A2540),
      secondary: Color(0xFFD4AF77),
      surface: Colors.white,
    ),
  );
}
